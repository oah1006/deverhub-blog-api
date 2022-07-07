<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\RegisterRequest;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request) {
        $data = $request->validated();

        $data['password'] = bcrypt($data['password']);

        $user = User::create($data);

        $token = $user->createToken('apitoken')->plainTextToken;

        Auth::login($user);

        return response()->json([
            'user' => $user,
            'token' => $token
        ], 201);
    }
}
