<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'message' => 'required|string',
            'g-recaptcha-response' => 'required|recaptcha',
        ]);

        $captcha = $request->input('g-recaptcha-response');
        $verified = true;
        if ($verified) {
            Mail::raw($data['message'], function ($message) use ($data) {
                $message->from($data['email'], $data['name']);
                $message->to('contact@artificially.io')->subject('Contact from ' . $data['name']);
            });
            return response(['message' => 'Email sent successfully'], 200);
        } else {
            \Log::info('reCAPTCHA failed', [
                'request' => $request->all(),
                'ip' => $request->ip(),
                'user-agent' => $request->userAgent(),
            ]);
            return response(['message' => 'reCAPTCHA verification failed'], 400);
        }
    }
}