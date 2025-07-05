<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMessageNotification;
use App\Mail\ContactMessageCopyToSender;


class mailController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'required|digits:10',
            'state'   => 'nullable|string|max:255',
            'city'    => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        $contact = ContactMessage::create($validated);

        Mail::to(config('mail.from.address'))->send(new ContactMessageNotification($contact));
        Mail::to($contact->email)->send(new ContactMessageCopyToSender($contact));

        return response()->json(['success' => true, 'message' => 'Message sent successfully.']);
    }
}
