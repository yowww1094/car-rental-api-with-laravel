<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UserLoginRequest;

class AuthController extends Controller
{
    use HttpResponses;

    public function add_user(StoreUserRequest $request)
    {
        $request->validated();

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->rank = $request->rank == 'manager' ? '0' : ($request->rank == 'admin' ?: '1' );
        $user->save();

        $token = $user->createToken('Token: ' . $user->name)->plainTextToken;

        if ($user) {
            return $this->success([
                'user' => $user,
                'token' => $token,
            ],
            'User Added Successfully');
        }
    }

    public function login(UserLoginRequest $request)
    {
        $request->validated;

        if (!Auth::attempt($request->only(['email', 'password']))) {
            return $this->error('', 'Incorrect E-mail or Password', 400);
        }

        $user = User::where('email', $request->email)->first();
        $token = $user->createToken('Token: ' . $user->name)->plainTextToken;

        return $this->success([
            'user' => $user,
            'token' => $token
        ]);
    }

    public function logout()
    {
        Auth::user()->currentAccessToken()->delete();

        return $this->success('', 'Logout Successfull and Token revoked');
    }
}
