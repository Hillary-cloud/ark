<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_id' => 'required',
            'service_id' => 'required|numeric',
            'slug' => 'required|string',
            'location_id' => 'required|numeric',
            'school_id' => 'required|numeric',
            'school_area_id' => 'required|numeric',
            'price' => 'required_without:on_contact|nullable|numeric',
            'on_contact' => 'required_without:price|boolean',
            'description' => 'required',
            'phone_number' => 'required|string',
            'seller_name' => 'required|string',
            'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'other_images' => 'nullable|array|max:4', // Allow up to 4 images
            'other_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            // 'expiration_date' => 'required|date|after:today', // Assuming the product should expire in the future.
            'active' => 'nullable|boolean',
            'draft' => 'nullable|boolean',
            // Add other validation rules for your fields here
        ];
    }

    public function messages()
    {
        return [
            'price.required_without' => 'Either "Price" or "On Contact" option must be selected.',
            'on_contact' => 'Either "On Contact" or "Price" option must be selected.',
            'service_id' => 'Service field is required',
            'school_id' => 'School field is required',
            'school_area_id' => 'School area field is required',
            'location_id' => 'Location field is required',
            'description' => 'Description field is required',
            'cover_image' => 'Cover image is required',
            'other_images' => 'Images should not be more than 4',
            'phone_number' => 'Phone number field is required',
            // Add custom error messages for other fields here
        ];
    }
}
