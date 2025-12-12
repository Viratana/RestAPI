<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function Login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);
        $user = User::where('email', $request->email)->first();
        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'These credentials do not match our records.',
            ], 401);
        }
        $token = $user->createToken('my-app-token')->plainTextToken;
        return response()->json([
            'user'  => $user,
            'token' => $token,
        ], 201);
    }

    public function Register(Request $request){
        $data = [
            'name'    => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ];
        $user = User::create($data);
        if($user){
            return response([
                'message' => ['User has been registered successfully!']
            ], 200);
        } else {
            return response([
                'message' => ['Something Went Wrong!']
            ], 404);
        }
    }
}
