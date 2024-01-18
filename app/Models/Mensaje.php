<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;


class Mensaje extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'mensajes';
    protected $fillable = [
        'content',
        'user_id',
        'chat_id'
    ];

    /**
    * ------- Relaciones -------
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }

    /**
     * Model Methods
     */

    /**
     * Función que crea un mensaje
     *
     * @param Array $data
     * @return Model
     */
    public function new_mensaje($data): Model
    {
        if ($data['content']!='') {

            $this->content = $data['content'];
            $this->user_id = Auth::user()->id;
            $this->chat_id = $data['chat_id'];

            $this->save();
        }


        return $this;
    }
}

