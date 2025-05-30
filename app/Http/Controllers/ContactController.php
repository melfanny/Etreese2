<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->back()->withErrors(['message' => 'You must be logged in to send a message.']);
        }

        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        Message::create([
            'user_id' => auth()->id(),
            'message' => $request->input('message'),
            'is_read' => false,
        ]);

        return redirect()->back()->with('success', 'Message sent successfully!');
    }
}
