<?php
namespace App\Custom\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserValidatorRegister
{
    /**
     * Función que valida el formulario de registro
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
                'name'=>'required',
                'nick'=>'required',
                'email'=>'required|email|unique:users',
                'password'=>[
                    'required',
                    'string',
                    'min:8',
                ]
            ]);

            $validation = Validator::make($request->input(),$rules);

            if ($validation->fails()) {
                return [
                    'status'=>419,
                    'value'=>$validation
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
