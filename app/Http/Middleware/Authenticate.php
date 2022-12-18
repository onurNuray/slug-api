<?php

namespace App\Http\Middleware;

use App\Exceptions\Login\LoginException;
use App\Models\Token;
use App\Models\User;
use Carbon\Carbon;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    public function handle(Request $request, Closure $next)
    {
        try {
            $bearerToken = $request->bearerToken();
            if (is_null($bearerToken)) {
                throw new LoginException('Bearer token is required', 401);
            }
            $key = env('JWT_TOKEN') ?? 'mykey';
            $jwtToken = JWT::decode($bearerToken, new Key($key, 'HS256'));
            $user = User::where('email', '=', $jwtToken->email)->first();
            $token = Token::where('user_id', $user->id)->where('token', $bearerToken)->exists();
            if (!$token) {
                throw new LoginException('Invalid token', 401);
            }
            if ($jwtToken->expire < Carbon::now()) {
                throw new LoginException('Token has expired', 401);
            }
            Auth::login($user, true);
            return $next($request);
        } catch (Exception $e) {
            throw new LoginException($e->getMessage(), 401);
        }
    }
}
