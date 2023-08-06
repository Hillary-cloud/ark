<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Advert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Unicodeveloper\Paystack\Paystack;

class PaymentController extends Controller
{
    
    public function showPaymentPage($uuid)
    {
        $advert = Advert::where('uuid',$uuid)->firstOrFail();
        // Pass the advert data to the payment page view
        return view('payment-page', compact('advert'));
    }

    protected $paystack;

    public function __construct(Paystack $paystack)
    {
        $this->paystack = $paystack;
    }


    public function redirectToGateway($uuid)
    {
        $advert = Advert::where('uuid',$uuid)->firstOrFail();
        $email = auth()->user()->email;
        $name = auth()->user()->name;
        // Replace this with your desired payment amount and other details
        // $amountInNaira = 100000;
        // $amountInKobo = $amountInNaira * 100; // Convert Naira to Kobo

        if ($advert->expiration_date == null && $advert->draft == false && $advert->active == false) {
            $paymentData = [
                'amount' => 80000, // Amount in kobo
                'email' => $email,
                'metadata' => [
                    'custom_fields' => [
                        ['display_name' => "Payment For", 'variable_name' => "payment_for", 'value' => "Ad Re-listing"],
                        ['display_name' => "Customer Name", 'variable_name' => "customer_name", 'value' => $name],
                        ['display_name' => "Ad UUID", 'variable_name' => "ad_uuid", 'value' => $uuid],
                    ]
                ]
            ];
        } else {
            $paymentData = [
                'amount' => 100000, // Amount in kobo
                'email' => $email,
                'metadata' => [
                    'custom_fields' => [
                        ['display_name' => "Payment For", 'variable_name' => "payment_for", 'value' => "Ad Listing"],
                        ['display_name' => "Customer Name", 'variable_name' => "customer_name", 'value' => $name],
                        ['display_name' => "Ad UUID", 'variable_name' => "ad_uuid", 'value' => $uuid],
                    ]
                ]
            ];
        }
        
        // Generate the callback URL with the UUID included
    $callbackUrl = URL::route('payment.callback', ['uuid' => $uuid]);

    // Append the callback URL to the payment data
    $paymentData['callback_url'] = $callbackUrl;

        return $this->paystack->getAuthorizationUrl($paymentData)->redirectNow();
    }
    
    public function handleGatewayCallback($uuid)
    {
        $expirationDate = Carbon::now()->addDays(30);
        $paymentDetails = $this->paystack->getPaymentData();

        $status = $paymentDetails['data']['status'];
        // dd($paymentDetails);

        // Process payment details and update your database accordingly
        // For example, you can check if the payment was successful and update the user's order status.
        if($status === 'success'){
            $advert = Advert::where('uuid',$uuid)->firstOrFail();
            $advert->update(['expiration_date' => $expirationDate, 'draft' => false, 'active' => true]);
        }
        
        return redirect()->route('success', ['uuid' => $advert->uuid]); // Redirect to a success page
    }

}
