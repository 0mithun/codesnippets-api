<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SignInController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'email'         =>  ['required','email'],
            'password'      =>  ['required'],
        ]);

        if($token = auth()->attempt($request->only('email','password'))){
            return response()->json(['data'=>[
                'token'     =>  $token,
            ]]);
        }

        return response(['errors'=>['email'=>['Could not signin with those credentials.']]], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
