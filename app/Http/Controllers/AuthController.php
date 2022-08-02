<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users',
            'name' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = new User();
        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->password = Hash::make($request['password']);
        $user->save();

        $user->setAttribute('access_token', 'Bearer ' . $user->createToken('login')->plainTextToken);

        return success($user);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::query()
            ->where('email', $request['email'])
            ->first();

        abort_if(!$user, 412, '账号密码不正确');
        abort_if(!Hash::check($request['password'], $user->password), 412, '账号密码不正确');

        $user->setAttribute('access_token', 'Bearer ' . $user->createToken('login')->plainTextToken);

        return success($user);
    }
}
