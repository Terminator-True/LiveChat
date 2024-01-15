<?php
namespace App\Custom\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserValidatorUpdate
{

    public function validate_password(Request $request)
    {

        try {
            $data = $request->input();
            if (Hash::check($data['actual_password'], Auth::user()->password)) {

                $rules = ([
                    'new_password'=>[
                        'required',
                        'string',
                        'min:8',
                        'regex:/[a-z]/',
                        'regex:/[A-Z]/',
                        'regex:/[0-9]/',
                        'regex:/[@$!%*#?&]/',
                    ]
                ]);

                $validation = Validator::make($data,$rules);

                if ($validation->fails()) {
                    return [
                        'status'=>419,
                        'value'=>'Password incorrect'
                    ];
                }

                return [
                    'status'=>200,
                    'value'=>$data['new_password']
                ];

            }

            return [
                'status'=>419,
                'value'=>'Password incorrect'
            ];
        } catch (Exception $e) {
            return [
                'status'=>500,
                'value'=> $e->getMessage()
            ];
        }

    }
    public function validate_user(Request $request)
    {

        try {
            $data = $request->input();

            $rules = ([
                'nick'=>[
                    'string',
                    'min:3',
                    'max:10',
                    'nullable'
                ],
                'name'=>[
                    'string',
                    'min:3',
                    'max:10',
                    'nullable'
                ],
                'img'=>[
                    'image',
                    'nullable',
                    'max:2000',
                    'dimensions:min_width=48,min_height=48,max_width=500,max_height=500'
                ]
            ]);

            $validation = Validator::make($data,$rules);

            if ($validation->fails()) {
                return [
                    'status'=>419,
                    'value'=>$validation
                ];
            }

            return [
                'status'=>200,
                'value'=>$request
            ];

        } catch (Exception $e) {
            return [
                'status'=>500,
                'value'=> $e->getMessage()
            ];
        }

    }

}