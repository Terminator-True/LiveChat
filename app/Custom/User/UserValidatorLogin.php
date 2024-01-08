<?php
namespace App\Custom\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserValidatorLogin
{

    public function validate(Request $request)
    {

        try {
            $rules = ([
                'email'=>'required',
                'password'=>'required'
            ]);

            $validation = Validator::make($request->input(),$rules);

            if ($validation->fails()) {
                return [
                    'status'=>419,
                    'value'=>'Email or Password incorrect'
                ];
            }

            $data =  request()->except(['_token']);;

            return [
                'status'=>200,
                'value'=>$data
            ];
        } catch (Exception $e) {
            return [
                'status'=>500,
                'value'=> $e->getMessage()
            ];
        }

    }

}
