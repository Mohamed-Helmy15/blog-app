<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Mail\confirmAccountEmail;
use App\Models\Employer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function login(Request $request) {
        $request->validate( [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $user = User::where('email', $request->email)->first();
    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json([
            'message' => 'Invalid email or password'
        ], 401);
    }
    $token = $user->createToken('my-app-token')->plainTextToken;
        return response()->json(['token' => $token, 'user' => $user ]);
    }

    public function logout(Request $request){
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out']);
    }

    public function signup(Request $request){
        $request->validate( [
            'name'=>'string|required|min:3|max:20',
            'email'=> 'required|email',
            'password'=> 'required|confirmed',
        ]);
        $user = User::create($request->all());
        if($request->role === "employer"){
            Employer::create([
                'user_id'=> $user->id,
            ]);
        };
        $token = $user->createToken('my-app-token')->plainTextToken;
        return response()->json(['token' => $token, 'user' => $user ]);
    }

    public function forgotPassword (Request $request){
        $request->validate([
            'email'=>'required|email',
        ]);
        $user = User::where('email', $request->email)->first();
        if(!$user){
            return response()->json([
                'message' => 'email not found'
            ], 401);
        }
        $remember_token = bin2hex(random_bytes(32));
        Mail::to($request->email)->send(new confirmAccountEmail($remember_token));
        $user->remember_token = $remember_token;
        $user->save();
        return response()->json([
            'message' => 'check your email and click the link'
        ]);
    }
    public function resetPassword(Request $request , string $token){
    $user = User::where('remember_token', $token)->first();
    if(!$user){
        return response()->json([
            'message' => 'Invalid Token'
        ], 401);
    }
    $request->validate([
        'password'=> 'required|confirmed',
    ]);
    $user->password = Hash::make($request->password);
    $user->remember_token = null;
    $user->save();
    return response()->json([
        'message'=>'the password has been updated',
    ], 200);
    }
}
