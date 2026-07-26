<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInquiryRequest;
use App\Models\Inquiry;

class InquiryController extends Controller
{
    public function store(StoreInquiryRequest $request)
    {
        if (now()->timestamp - (int) $request->input('form_started') < 3) {
            return back()->withInput()->withErrors(['full_name' => 'Unable to submit this request. Please try again.']);
        }

        if ((int) $request->input('captcha_answer') !== (int) session('form_captcha_answer')) {
            return back()->withInput()->withErrors(['captcha_answer' => 'Please answer the security question correctly.']);
        }

        Inquiry::create([
            'full_name' => $request->input('full_name'),
            'contact_number' => $request->input('contact_number'),
            'email' => $request->input('email'),
            'subject' => $request->input('subject'),
            'category' => $request->input('category'),
            'message' => $request->input('message'),
        ]);

        $request->session()->forget('form_captcha_answer');

        return redirect()->back()->with('success', 'Your inquiry has been sent.');
    }
}
