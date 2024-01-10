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

        $user_creation_status = $this->user->create($result['value']);

        if ($user_creation_status != 200) return view('registerAndLogin');

        return redirect(route('web.home'));

    }

    public function login(Request $request, UserValidatorLogin $login_validator)
    {
        $result = $login_validator->validate($request);

        if ($result['status'] != 200) {
            return view('registerAndLogin')->with(['error'=>'Mail or Password incorrect']);
        }

        $user_login_status = $this->user->login($result['value']);

        if( $user_login_status != 200 )
        {
            return view('registerAndLogin')->with(['error'=>'Mail or Password incorrect']);
        }

        return redirect(route('web.home'));

    }

    public function logout()
    {
        $user_logout_status = $this->user->logout();

        if($user_logout_status) return redirect(route('web.form'));
    }

}
