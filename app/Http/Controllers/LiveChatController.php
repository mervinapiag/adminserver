<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LiveChat;
use App\Models\LiveChatMessage;

class LiveChatController extends Controller
{
    public function customerCheck($id) 
    {
        $check = LiveChat::where('user_id', $id)->first();

        if ($check) {
            return $this->customerOpenChat($id);
        } else {
            return response()->json([
                'Chat not found'
            ], 404);
        }
    }

    public function customerStartChat($id)
    {
        LiveChat::create([
            'reference_no' => $this->generateReferenceNo(),
            'user_id' => $id,
            'staff_id' => 0
        ]);

        return response()->json([
            'chat started'
        ], 200);
    }

    public function customerSendChat(Request $request, $id)
    {
        $chat = LiveChat::where('user_id', $id)->first();

        LiveChatMessage::create([
            'live_chat_id' => $chat->id,
            'user_id' => $id,
            'message' => $request->message
        ]);

        return $this->customerOpenChat($id);
    }

    public function customerOpenChat($id)
    {
        return LiveChat::where('user_id', $id)->first();
    }

    private function generateReferenceNo($code = 'CHAT') 
    {
        $max_code = $code . '00001';
        $max_id = LiveChat::max('id');
        if ($max_id) {
            $max_code = substr($max_code, 0, -strlen($max_id)) . '' . ($max_id + 1);
        }
        return $max_code;
    }

    public function adminListChats()
    {
        return LiveChat::all();
    }

    public function adminOpenChat($id)
    {
        return LiveChat::where('id', $id)->first();
    }

    public function adminSendChat(Request $request, $id)
    {
        $chat = LiveChat::where('id', $id)->first();

        LiveChatMessage::create([
            'live_chat_id' => $chat->id,
            'user_id' => $request->user_id,
            'message' => $request->message
        ]);

        return $this->adminOpenChat($id);
    }
}
