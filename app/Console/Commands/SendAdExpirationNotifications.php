<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Notifications\AdExpired;
use App\Models\Advert; // Adjust the namespace and model name as needed

class SendAdExpirationNotifications extends Command
{
    
    protected $signature = 'ads:send-expiration-notifications';
    protected $description = 'Send notifications for expired ads';

    public function handle()
    {
        $expiredAds = Advert::where('expiration_date', null)->where('notification_sent', false)->where('active',false)->where('draft',false)->get();

        foreach ($expiredAds as $ad) {
            $ad->user->notify(new AdExpired($ad));

            // Mark the notification as sent
        $ad->update(['notification_sent' => true]);
        }

        $this->info('Ad expiration notifications sent successfully.');
    }
}
