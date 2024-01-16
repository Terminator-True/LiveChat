<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public $chat;
    public function __construct(Chat $chat)
    {
        $this->chat = $chat;
    }
    public function eliminar_chat(Request $request)
    {
        $chat_id = $request->get('chat_id');

        return $this->chat->eliminar($chat_id);


    }

    public function crear_chat(Request $request)
    {
        return $this->chat->crear_chat($request);
    }
}
