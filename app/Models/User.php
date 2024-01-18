<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;




class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'img',
        'nick',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    /**
    * ------- Relaciones -------
    */

    public function chats()
    {
        return $this->belongsToMany(Chat::class,'chat_user');
    }

    public function mensaje()
    {
        return $this->hasOne(Mensaje::class);
    }

    /**
     * Model Methods
     */

    /**
     * Crea un usuario a partir de los datos recibidos
     *
     * @param Array $data
     * @return int
     */
    public function create($data): int
    {
        $user = new User();

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->nick = $data['nick'];
        $user->type = 0;
        $user->password = Hash::make($data['password']);
        $user->img = 'vacio';
        $user->save();

        return 200;

    }

    /**
     * Actualizamos al usuario autenticado
     *
     * @param Request $request
     * @return bool
     */
    public function update_user(Request $request): bool
    {
        try {

            $data = $request->input();
            $user = Auth::user();

            //Eliminamos de la array los campos "NULL"
            $data = array_filter($data, fn($val) => !is_null($val));
            $result =  $user->update($data);//FIX

            if ($request->has('img')) {

                $file = "data:image/png;base64,".base64_encode(file_get_contents($request->file('img')->path()));

                $user->update([
                    'img'=>$file
                ]);
            }

            return true;
        } catch (Exception $e) {
            // return $e->getMessage();
            return false;
        }

    }

    /**
     * Actualizamos el password del usuario autenticado
     *
     * @param String $new_password
     *
     * @return bool
     */
    public function update_password($new_password): bool
    {

        Auth::user()->update([
            'password'=>Hash::make($new_password)
        ]);

        return true;


    }

    /**
     * Autenticamos al usuario
     *
     * @param $data
     *
     * @return int
     */
    public function login($data): int
    {
        if (Auth::attempt($data)) {
            request()->session()->regenerate();
            return 200;
        }
        return 400;

    }

    /**
     * Deslogueamos al usuario
     *
     * @return bool
     */
    public function logout(): bool
    {
        $this->all_chat_unbinding();
        Auth::logout();
        return true;
    }

    /**
     * Preguntamos si el usuario es admin
     * @return bool
     */
    public function is_sa(): bool
    {
        return ($this->type == 1) ? true:false;
    }

    /**
     * Añadimos al usuario al chat
     * @param $chat_id
     * @return bool
     */
    public function chat_binding($chat_id): bool
    {
        if (! $this->chats->count()==0) {
            $this->chats()->attach($chat_id);
            return true;
        }

        return false;
    }

    /**
     * Quitamos al usuario del chat
     * @param $chat_id
     * @return bool
     */
    public function chat_unbinding($chat_id): bool
    {
        $this->chats()->detach($chat_id);

        return true;
    }

    /**
     * Quitamos al usuario
     * @param $chat_id
     * @return bool
     */
    public function all_chat_unbinding(): bool
    {
        $this->chats()->detach();

        return true;
    }
}

