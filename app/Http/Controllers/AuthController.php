<?php

namespace App\Http\Controllers;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class AuthController extends Controller {
    public function register(RegisterRequest $req) {
        syslog(LOG_INFO, 'Registering user: ' . $req->input('email'));
        $data = $req->validated();
        $user = User::create([
            'name'=>$data['name'],
            'email'=>$data['email'],
            'password'=>bcrypt($data['password']),
        ]);
        $token = $user->createToken('api')->plainTextToken;
        return response()->json(['token'=>$token, 'user'=>$user], 201);
    }

    public function login(LoginRequest $req){
        $cred = $req->validated();
        if (!Auth::attempt(['email'=>$cred['email'],'password'=>$cred['password']])){
            return response()->json(['message'=>'invalid_credentials'], 401);
        }
        $user = $req->user();
        $token = $user->createToken('api')->plainTextToken;
        return response()->json(['token'=>$token, 'user'=>$user]);
    }

    public function me(Request $req){ return $req->user(); }

    public function logout(Request $req){
        $req->user()->currentAccessToken()->delete();
        return response()->json(['message'=>'logged_out']);
    }
}