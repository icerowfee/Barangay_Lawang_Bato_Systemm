<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function sendEmail(Request $request)
    {
        $data = $request->validate([
            'firstname'    => ['required', 'string', 'max:255'],
            'lastname'    => ['required', 'string', 'max:255'],
            'email'   => ['required', 'email'],
            'user_message' => ['required', 'string'],
        ]);

        Mail::send('user.user-message', $data, function ($message) use ($data) {
            $message->to('anaelmagbag45@gmail.com')
                    ->subject('Message from ' . $data['firstname'] . ' ' . $data['lastname'])
                    ->replyTo($data['email']);
        });

        return back()->with('success', 'Email sent successfully!');
    }
}