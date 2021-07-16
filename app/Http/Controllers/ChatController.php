<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\ChatRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function rooms(Request $request)
    {
        return ChatRoom::all();
    }

    public function messages(Request $request, int $roomId)
    {
        return ChatMessage::whereHas('room', function ($query) use ($roomId) {
            $query->find($roomId);
        })
            ->with('user')
            ->older()
            ->get();
    }

    public function newMessage(Request $request, int $roomId)
    {
        return ChatMessage::create([
            'user_id' => Auth::id(),
            'chat_room_id' => $roomId,
            'message' => $request->message
        ]);
    }
}
