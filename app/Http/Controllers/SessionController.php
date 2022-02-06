<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use GuzzleHttp\Exception\BadResponseException;

class SessionController extends Controller
{
    public function login(LoginRequest $request)
    {
        #check validation
        $attributes = $request->validated();
        #check email and password match
        if (!auth()->attempt($attributes)) {
            #if didn't match
            return response()->json([
                'status' => 500,
                'message' => 'fail',
                'data' => [
                    'error' => 'email and password dont match'
                ],
            ]);
        }
        #if did match
        session()->regenerate(); #regenerate user
        $user = auth()->user(); #get auth user
        /** @var \App\Models\MyUserModel $user **/
        $token = $user->createToken('userLoginToken')->accessToken; #get token from auth user
        return response()->json([
            'status' => 200,
            'message' => 'success',
            'data' => $user,
            'token' => $token
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}
