<?php

namespace App\Custom\Chat;

use App\Models\Chat;
use App\Models\User;
use App\Models\Mensaje;

class PrepareChatData
{
    /**
     * Función que prepara los datos para la vista chat
     *
     * @param $chat_id Id del chat del que queremos preparar los datos
     *
     * @return array $final_data
     */
    public function prepare_chat_data($chat_id): array
    {
        $chat_data = Chat::query()->where('id',$chat_id)->first();

        $mensajes = Mensaje::query()
                                ->where('chat_id',$chat_id)
                                ->with('image')
                                ->take(30)
                                ->get();

        $final_data =  [
            'chat'=>$chat_data,
            'mensajes'=>$mensajes,

        ];

        return $final_data;


    }
}
