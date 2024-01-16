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

            if ($request->hasFile('img')) {
                $file = $request->file('img');


                $image_rules = [
                    'img'=>[
                        'mimes:jpeg,jpg,png,gif',
                        'nullable',
                        'max:2048',
                ]];

                $image_validation = Validator::make(['img'=>$file],$image_rules);

                if ($image_validation->fails()) {
                    return [
                        'status'=>419,
                        'value'=>$image_validation
                    ];
                }
            }

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
