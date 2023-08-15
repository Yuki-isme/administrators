<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Closure;


class Authenticate extends Middleware
{
    protected $redirectTo = [
        'admin' => 'admin.login',
        'web' => 'login',
    ];

    public function handle($request, Closure $next, ...$guards)
    {
        if (empty($guards)) {
            $guards = ['web'];
        }

        foreach ($guards as $guard) {
            if (!$this->auth->guard($guard)->check()) {
                return redirect()->route($this->redirectTo[$guard]);
            }
        }

        return $next($request);
    }
}
