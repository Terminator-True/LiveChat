<?php

namespace App\Http\Controllers;

use App\Custom\User\UserValidatorLogin;
use App\Models\User;
use App\Custom\User\UserValidatorRegister;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function show_form()
    {
        return view('registerAndLogin');
    }

    public function register(Request $request,UserValidatorRegister $register_validator)
    {
        $result = $register_validator->validate($request);

        if ($result['status'] != 200) {
            return view('registerAndLogin')->with(['error'=>'Mail or Password incorrect']);
        }

        if ($this->user->create($result['value']) != 200) return view('registerAndLogin');

        return view('welcome');



    }

    public function login(Request $request, UserValidatorLogin $login_validator)
    {
        $result = $login_validator->validate($request);

        if ($result['status'] != 200) {
            return view('registerAndLogin')->with(['error'=>'Mail or Password incorrect']);
        }

       if( $this->user->login($result['value']) != 200 )
        {
            return view('registerAndLogin')->with(['error'=>'Mail or Password incorrect']);
        }

        return view('welcome');

    }

    public function logout()
    {
        if($this->user->logout()) return view('welcome');

    }

}
