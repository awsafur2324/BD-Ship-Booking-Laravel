<?php

namespace App\Http\Middleware;

use App\Helper\JWT_token;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForgetPassToken_middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token=$request->cookie('forgot_password_token');
        $result=JWT_token::VerifyToken($token);
        if($result=="unauthorized"){
            return response()->json(['message' => 'Token is not valid or expired.'], 401);
        }
        else{
            $request->headers->set('email',$result->userEmail);
            return $next($request);
        }
    }
}
