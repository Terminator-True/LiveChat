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

    public function create($data)
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

    public function update_user(Request $request)
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

            return True;
        } catch (Exception $e) {
            return $e->getMessage();
        }



        return True;
    }

    public function update_password($new_password)
    {

        Auth::user()->update([
            'password'=>$new_password
        ]);

        return true;


    }

    public function login($data)
    {
        if (Auth::attempt($data)) {
            request()->session()->regenerate();
            return 200;
        }
        return 400;

    }

    public function logout()
    {
        Auth::logout();
        return true;
    }

    public function is_sa()
    {
        return ($this->type == 1) ? true:false;
    }
}

