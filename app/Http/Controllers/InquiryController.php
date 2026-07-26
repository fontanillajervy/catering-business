<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInquiryRequest;
use App\Models\Inquiry;

class InquiryController extends Controller
{
    public function store(StoreInquiryRequest $request)
    {
        Inquiry::create([
            'full_name' => $request->input('full_name'),
            'contact_number' => $request->input('contact_number'),
            'email' => $request->input('email'),
            'subject' => $request->input('subject'),
            'category' => $request->input('category'),
            'message' => $request->input('message'),
        ]);

        return redirect()->back()->with('success', 'Your inquiry has been sent.');
    }
}
