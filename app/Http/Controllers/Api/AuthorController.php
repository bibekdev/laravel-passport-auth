<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function register(Request $request)
    {
        // validate
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:authors',
            'password' => 'required|confirmed',
            'phone_no' => 'required'
        ]);

        // create 
        $author = new Author();
        $author->name = $request->name;
        $author->email = $request->email;
        $author->password = bcrypt($request->password);
        $author->phone_no = $request->phone_no;

        $author->save();

        return response()->json([
            'staus' => 1,
            'message' => 'Author created successfully'
        ]);
    }

    public function login(Request $request)
    {
        // validate
        $login_data = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($login_data)) {
            return response()->json([
                'status' => 0,
                'message' => 'Invalid Credentials'
            ]);
        }

        $token = auth()->user()->createToken('auth_token');

        return response()->json([
            'status' => 1,
            'message' => 'Logged in successfully',
            'access_token' => $token
        ]);
    }

    public function profile()
    {
        $user_data = auth()->user();

        return response()->json([
            "status" => true,
            "message" => "User data",
            "data" => $user_data
        ]);
    }

    public function logout()
    {
        // get token value
        $token = $request->user()->token();

        // revoke this token value
        $token->revoke();

        return response()->json([
            "status" => true,
            "message" => "Author logged out successfully"
        ]);
    }
}
