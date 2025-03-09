<?php

namespace App\Http\Middleware;

use App\Helper\JWT_token;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class verifyToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $token = $request->cookie('token');
        $result = JWT_token::VerifyToken($token);
        if ($result == "unauthorized") {
            Session::put('url.intended', url()->current());
            return redirect('/login');
        } else {
            $request->headers->set('email', $result->userEmail);
            $request->headers->set('id', $result->userID);
            $user = User::where('id', $result->userID)->first();

            if ($user) {
                $request->session()->put('user_name', $user->name);

                if ($user->role && $user->manager_verified === "true") {
                    $request->session()->put('user_role', 'manager');
                } elseif ($user->role && $user->admin_verified === "true") {
                    $request->session()->put('user_role', 'admin');
                } else {
                    $request->session()->put('user_role', 'user');
                }

                return $next($request);
            }
            else{
                Session::put('url.intended', url()->current());
                return redirect('/login');
            }
        }
    }
}
