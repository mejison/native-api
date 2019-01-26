<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;

class AuthController extends Controller
{
    public function login(Request $request) {
        $user = User::where('email', $request->email)->first();
        if ( ! $user)
            return response()->json(['data' => false, 'message' => 'Record not found.'], 404);
                
        if (app('hash')->check($request->password, $user->password)) {
            $user->token = base64_encode(str_random(40));
            $user->save();
            return response()->json(['data' => $user], 200);
        }

        return response()->json(['data' => false, 'message' => 'Incorrect credentials.'], 400);
    }

    public function register(Request $request) {
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = app('hash')->make($request->password);
        $user->save();

        return response()->json(['data' => $user, 'message' => 'Successfuly created.'], 201);
    }
}
