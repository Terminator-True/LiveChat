<?php

namespace App\Models;

use App\Traits\UploadImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;


class Mensaje extends Model
{
    use HasFactory,SoftDeletes, UploadImage;

    protected $table = 'mensajes';
    protected $fillable = [
        'content',
        'type',
        'user_id',
        'chat_id',
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

    public function image()
    {
        return $this->hasOne(Image::class);
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
            $this->type = $data['type'];
            $this->content = $data['content'];
            $this->user_id = Auth::user()->id;
            $this->chat_id = $data['chat_id'];

            $this->save();

            if($data['type'] == 'img'){
                $this->uploadImage($data['img'], $this);
            }
        }


        return $this;
    }
}

