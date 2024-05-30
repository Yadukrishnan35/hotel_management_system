<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class userController extends Controller
{
    public function user_login() {
        return view('user.login_user');
    }

    public function user_register() {
        return view('user.user_register');
    }

    public function save_user(Request $request) {
        try {
            $messages = [
                'email' => 'The email must contain the @ symbol.',
                'email.unique' => 'The email has already been taken.',
                'gender'=>'Choose Gender'
                // other custom messages
            ];
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'phone' => 'required|string|max:15|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ],$messages);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $user = User::create([
                'name' => $request->fname,
                'username' => $request->uname,
                'phone' => $request->ph,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'gender' => $request->gender
        ]);
            return response()->json(['message' => 'User added successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to add user', 'message' => $e->getMessage()], 500);
        }
    }
    
}
