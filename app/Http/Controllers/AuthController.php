<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $validate = $validator->validated();
        $validate['passsword'] = Hash::make($request['password']);

        User::create($validate);
        // create token
        $token = Auth::attempt($request->only(['email','password']));

        return $this->createNewToken($token);

    }

    public function login(Request $request)
    {
        $credentials = $request->only(['email','password']);

        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['message' => 'Wrong credentials'], 401);
        }

        return $this->createNewToken($token);

    }

    public function refresh()
    {
        $token = auth()->refresh();
        return $this->createNewToken($token);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expired_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }
}
