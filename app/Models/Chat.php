<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

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

    public function mensaje()
    {
        return $this->hasOne(Mensaje::class);
    }


    /**
     * Model methods
     */

    public function get()
    {
        $chats = $this::query()->where('id','>',0)->get();

        $final_data = $chats->map(function($chat){
            return ['name'=> $chat->name,'description'=>$chat->description, 'actual_users'=>$chat->users->count()];
        });

        return $final_data->toArray();


    }
}
