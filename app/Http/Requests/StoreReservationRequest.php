<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReservationRequest extends FormRequest
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
            'address' => ['required', 'string', 'max:500'],
            'event_type' => ['required', 'string', 'max:100'],
            'event_date' => ['required', 'date', 'after_or_equal:today'],
            'event_time' => ['required', 'string', 'max:20'],
            'venue' => ['required', 'string', 'max:255'],
            'guest_count' => ['required', 'integer', 'min:1', 'max:1000'],
            'estimated_budget' => ['required', 'numeric', 'min:0'],
            'package_id' => ['required', 'exists:packages,id'],
            'additional_services' => ['nullable', 'string', 'max:1000'],
            'special_requests' => ['nullable', 'string', 'max:1000'],
            'additional_notes' => ['nullable', 'string', 'max:1000'],
            'website' => ['prohibited'],
            'form_started' => ['required', 'integer'],
            'captcha_answer' => ['required', 'integer', 'min:0', 'max:99'],
        ];
    }

    public function messages(): array
    {
        return [
            'full_name.required' => 'Please provide your full name.',
            'contact_number.required' => 'Please provide a contact number.',
            'email.required' => 'Please provide your email address.',
            'event_date.after_or_equal' => 'Event date must be today or later.',
            'guest_count.max' => 'Guest count cannot exceed 1000.',
            'captcha_answer.required' => 'Please answer the security question.',
        ];
    }
}
