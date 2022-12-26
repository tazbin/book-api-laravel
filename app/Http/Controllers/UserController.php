<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function register(Request $request) {
        $fields = $request->validate(([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ]));

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function login(Request $request) {
        $fields = $request->validate(([
            'email' => 'required|string',
            'password' => 'required|string'
        ]));

        $user = User::where('email', $fields['email'])->first();

        if( !$user || !Hash::check($fields['password'], $user->password) ) {
            return response([
                'message' => 'wrong username or password',
                'error' => [
                    'message' => 'worng username or password',
                    'code' => 401
                ]
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function logout(Request $request) {

        if( !$request->user()->currentAccessToken() ) {
            return response([
                'message' => 'No tokens, retry later'
            ], 403);
        }

        $request->user()->currentAccessToken()->delete();

        return response([
            'message' => 'used logged out'
        ], 201);
    }

    public function show($id) {

        // how do i select title & page field for book ?
        $user = User::with(['contact:user_id,phone,address', 'books.categories:name'])->select('id', 'email', 'name')->find($id);

        $response = response([
            'user' => $user
        ]);

        return $response;
    }
}
