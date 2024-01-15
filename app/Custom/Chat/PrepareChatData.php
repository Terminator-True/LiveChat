<?php

namespace App\Custom\Chat;

use App\Models\Chat;
use App\Models\User;
use App\Models\Mensaje;

class PrepareChatData
{
    public function prepare_chat_data($chat_id)
    {
        $chat_data = Chat::query()->where('id',$chat_id)->first();

        $mensajes = Mensaje::query()
                                ->where('chat_id',$chat_id)
                                ->take(100)
                                ->get();

        $final_data =  [
            'chat'=>$chat_data,
            'mensajes'=>$mensajes,
        ];

        return $final_data;


    }
}
