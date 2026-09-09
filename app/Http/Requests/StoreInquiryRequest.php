<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInquiryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name' => ['required', 'string', 'max:255'],
            'contact_number' => ['required', 'string', 'max:20'],
            'email' => ['required', 'email'],
            'subject' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'message' => ['required', 'string', 'max:2000'],
            'website' => ['prohibited'],
            'form_started' => ['required', 'integer'],
            'g-recaptcha-response' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'full_name.required' => 'Please provide your full name.',
            'contact_number.required' => 'Please provide a contact number.',
            'email.required' => 'Please provide your email address.',
            'message.required' => 'Please share your inquiry details.',
            'g-recaptcha-response.required' => 'Please verify that you are not a robot.',
        ];
    }
}
