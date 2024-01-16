<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Chat extends Model
{
    use HasFactory,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = 'chats';

    protected $fillable = [
        'name',
        'description',
    ];

    /**
    * ------- Relaciones -------
    */

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function mensajes()
    {
        return $this->hasMany(Mensaje::class);
    }


    /**
     * Model methods
     */

    public function get()
    {
        $chats = $this::query()->where('id','>',0)->get();

        $final_data = $chats->map(function($chat){
            return [
                'id'=>$chat->id,
                'name'=> $chat->name,
                'description'=>$chat->description,
                'actual_users'=>$chat->users->count()
            ];
        });

        return $final_data->toArray();

    }


    public function eliminar($chat_id)
    {
        if ($chat_id > 0) {

            $chat = $this::query()->where('id',$chat_id)->first();

            $id_mensajes = $chat->mensajes->pluck('id')->toArray();

            Mensaje::query()->whereIn('id',$id_mensajes)->each(function ($message, $key){
                $message->delete();
            });

            $chat->delete();

            return true;
        }

        return false;
    }

    public function crear_chat(Request $request)
    {
        $data = $request->input();
        if ($data['name']!='' && $data['description']!='') {
            $this->name = $data['name'];
            $this->description = $data['description'];

            $this->save();
            return true;
        }

        return false;
    }

}
