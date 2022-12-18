<?php

namespace App\Http\Controllers;

use App\Exceptions\Login\LoginException;
use App\Http\Requests\Login\LoginRequest;
use App\Http\Requests\Login\LogoutRequest;
use App\Models\Token;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        try {
            $user = User::where('email', $request->email)->first();

            if (!Hash::check($request->password, $user->password)) {
                throw new LoginException('Password is incorrect', 401);
            }
            $key = env('JWT_TOKEN') ?? 'mykey';
            $expire = Carbon::now()->addHours(24);
            $payload = [
                'email' => $user->email,
                'expire' => $expire
            ];
            $jwt = JWT::encode($payload, $key, 'HS256');
            $token = new Token();
            $token->user_id = $user->id;
            $token->token = $jwt;
            $token->expire = $expire;
            $token->save();

            $result = [
                'status' => true,
                'message' => 'Login Successfull',
                'data' => [
                    'token' => $jwt,
                    'expire' => $expire
                ],
            ];

            return response($result, 200);
        } catch (Exception $e) {
            throw new LoginException('User could not login', 401);
        }
    }

    public function logout(LogoutRequest $request)
    {
        try {
            $jwtToken = $request->bearerToken();
            $token = Token::where('token', $jwtToken)->delete();
            Auth::logout();

            $result = [
                'status' => true,
                'message' => 'Logout Successfull',
            ];

            return response($result, 200);
            
        } catch (Exception $e) {
            throw new LoginException('Logout was failed. Please try again', 401);
        }
    }
}
