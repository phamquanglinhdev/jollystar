<?php

namespace App\Http\Controllers\Admin;

use App\Events\SendMessage;
use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Conversation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $conversation = $request->conversation ?? null;
        if ($conversation != null) {
            $current = Conversation::find($conversation);
        } else {
            $current = Conversation::first();
        }
        $bag = [
            'conversations' => Conversation::all(),
            'current' => $current
        ];
        return view("message.list", $bag);
    }

    public function send(Request $request)
    {
        $chat = Chat::create([
            "conversation_id" => $request->conversation_id ?? 1,
            "text" => $request->text ?? "🥺",
            "user_id" => backpack_user()->id,
        ]);
        SendMessage::dispatch($chat);
        return (string)view("components.chat-from", ['chat' => $chat]);
    }
}
