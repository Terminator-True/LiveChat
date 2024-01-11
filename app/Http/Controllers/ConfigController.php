<?php

namespace App\Http\Controllers;

use App\Custom\User\UserValidatorUpdate;
use App\Models\User;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    public $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        return view('user-config');
    }

    public function update()
    {

    }

    public function update_password(Request $request, UserValidatorUpdate $validator)
    {
        $validated_password = $validator->validate_password($request);
        if ($validated_password['status'] == 200) {

            $this->user->update_password($validated_password['value']);
            return true;
        }

        return false;
    }
}
