<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        #Check Validation
        $attributes = $request->validated();
        #bcrypt Password
        $attributes['password'] = bcrypt(request('password'));
        #user create
        $user = User::create($attributes);
        #auth login
        auth()->login($user);
        #create token
        $token = $user->createToken('userRegisterToken')->accessToken;
        #return response;
        return response()->json([
            'status' => 200,
            'message' => 'success',
            'data' => $user,
            'token' => $token
        ]);
    }
}
