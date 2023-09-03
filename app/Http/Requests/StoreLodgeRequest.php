<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLodgeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_id' => 'required',
            'lodge_id' => 'required|numeric',
            'slug' => 'required|string',
            'location_id' => 'required|numeric',
            'school_id' => 'required|numeric',
            'school_area_id' => 'required|numeric',
            'price' => 'required|numeric',
            'agent_fee' => 'nullable|numeric',
            'negotiable' => 'nullable|boolean',
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
            'price' => 'Price field is required.',
            'lodge_id' => 'Lodge field is required',
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
