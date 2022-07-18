<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Exception;

class BasicAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $unauthorizedResponse = response()->json([
            'message' => 'Unauthorized',
        ], 401)->header('WWW-Authenticate', 'Basic realm="Access denied"');
        if ((empty($_SERVER['PHP_AUTH_USER']) || empty($_SERVER['PHP_AUTH_PW']))) {
            return $unauthorizedResponse;
        }
        try {
            $user = User::where('email', $_SERVER['PHP_AUTH_USER'])->take(1)->get();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Something went wrong. Contact API support',
            ], 500);
        }
        if (!count($user) || ($user->toArray()[0]['password'] !== $_SERVER['PHP_AUTH_PW'])) {
            return $unauthorizedResponse;
        }
        return $next($request);
    }
}
