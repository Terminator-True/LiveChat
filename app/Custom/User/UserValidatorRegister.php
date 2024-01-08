<?php
namespace App\Custom\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserValidatorRegister
{

    public function validate(Request $request)
    {

        try {
            $rules = ([
                'name'=>'required',
                'nick'=>'required',
                'email'=>'required|email|unique:users',
                'password'=>[
                    'required',
                    'string',
                    'min:8',
                    'regex:/[a-z]/',
                    'regex:/[A-Z]/',
                    'regex:/[0-9]/',
                    'regex:/[@$!%*#?&]/',
                ]
            ]);

            $validation = Validator::make($request->input(),$rules);

            if ($validation->fails()) {
                return [
                    'status'=>419,
                    'value'=>'Email or Password incorrect'
                ];
            }

            return [
                'status'=>200,
                'value'=>$request->input()
            ];
        } catch (Exception $e) {
            return [
                'status'=>500,
                'value'=> $e->getMessage()
            ];
        }

    }

}
