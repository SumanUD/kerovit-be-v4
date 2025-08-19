<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    /**
     * Display a listing of the messages.
     */
    public function index()
    {
        $messages = ContactMessage::latest()->get();
        return view('admin.contact-message.index', compact('messages'));
    }

    /**
     * Remove the specified message from storage.
     */
    public function destroy($id)
    {
        $message = ContactMessage::findOrFail($id);
        $message->delete();

        return redirect()->route('contact-messages.index')->with('success', 'Message deleted successfully.');
    }
}
