<?php
namespace App\Custom\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserValidatorLogin
{
    /**
     * Función que valida el login
     *
     * @param Request $request
     *
     * @return array status -> 419 == Validation error
     *                      -> 200 == Validation OK
     */
    public function validate(Request $request): array
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
