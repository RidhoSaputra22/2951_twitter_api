<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // dd(Auth::check());
        if (Auth::check()) {
            return response()->json([
                'status' => 200,
                'user' => Auth::user(),
                'message' => 'User has login'
            ]);
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            return response()->json([
                'status' => 200,
                'user' => $user,
                'message' => 'Login successful'
            ]);
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized'
            ]);
        };
    }

    public function regist(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'tanggal_lahir' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'avatar' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // dd($request->all());

        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'tanggal_lahir' => Carbon::parse($request->tanggal_lahir),
            'avatar' => $request->avatar ?? config('app.url') . '/file/users/default.png',
        ]);

        return response()->json([
            'status' => 200,
            'user' => $user,
            'message' => 'User created successfully'
        ]);
    }
}
