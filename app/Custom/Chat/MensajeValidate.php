<?php
namespace App\Custom\Chat;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MensajeValidate
{

    public function validate(Request $request)
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
