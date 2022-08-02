<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'source' => 'required|string|in:group,friend',
            'to' => 'required|string',
            'type' => 'required|string|in:string,image',
            'payload' => 'required',
        ]);

        $message = new Message($data);
        $message->user_id = authUser()->getKey();
        $message->save();

        return message('发送成功');
    }
}
