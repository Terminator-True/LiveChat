<?php

namespace App\Http\Controllers;

use App\Custom\Chat\PrepareChatData;
use App\Custom\Chat\MensajeValidate;
use App\Events\ChatEvent;
use Illuminate\Http\Request;
use App\Models\Mensaje;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public $mensaje;

    public function __construct(Mensaje $mensaje)
    {
        $this->mensaje = $mensaje;
    }

    public function index($chat_id,PrepareChatData $prepareChatData)
    {
        $data = $prepareChatData->prepare_chat_data($chat_id);
        Auth::user()->chat_binding($chat_id);
        return view('chat')->with('data',$data);
    }
    public function enviar(Request $request,MensajeValidate $validator)
    {
        $validated_message = $validator->validate($request);

        if ($validated_message['status'] == 200) {

            $mensaje = $this->mensaje->new_mensaje($validated_message['value']);

            broadcast(new ChatEvent($mensaje))->toOthers();

            return $mensaje;
        }

        return $validated_message['status'];

    }

    public function recibir(Request $request)
    {
        $user_id = $request->input()['user_id'];
        $user_data = User::select('nick','img')->where('id',$user_id)->first();
        return $user_data;
    }
}
