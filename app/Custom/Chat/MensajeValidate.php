<?php
namespace App\Custom\Chat;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MensajeValidate
{

    /**
     * Función que valida el mensaje enviado a un chat
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
                'content'=>[
                    'max:1500'
                ]
            ]);

            $validation = Validator::make($request->input(),$rules);

            if ($validation->fails()) {
                return [
                    'status'=>419,
                    'value'=>$validation
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
