<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Closure;


class Authenticate extends Middleware
{
    protected $redirectRoute = [
        'admin' => 'admin.login',
        'web' => 'login',
    ];
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    public function handle($request, Closure $next, ...$guards)
    {
        if(!empty($guards)){
            $guards=['web'];
        }

        foreach($guards as $guard)
        {
            if($this->auth->guard($guard)->check()){
                return redirect()->route($this->redirectRoute[$guard]);
            }
        }


        return $next($request);
    }
}
