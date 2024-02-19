<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    //

    public function retrieveMessages($recipientId)
    {
        // Retrieve messages between the authenticated user (sender) and the recipient
        $messages = Message::where(function ($query) use ($recipientId) {
            $query->where('sender', Auth::id())
                  ->where('receiver', $recipientId);
        })->orWhere(function ($query) use ($recipientId) {
            $query->where('sender', $recipientId)
                  ->where('receiver', Auth::id());
        })->orderBy('created_at')->get();

        // Return the messages as JSON data
        return response()->json(['messages' => $messages]);
    }

}
