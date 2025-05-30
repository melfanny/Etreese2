<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        // Fetch all messages with user relation, ordered by latest
        $messages = Message::with('user')->latest()->get();

        // Return the admin messages view with messages data
        return view('admin.message', compact('messages'));
    }
}
