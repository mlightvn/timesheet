<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Guard;

class AdminAuthenticate
{
    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(in_array($request->path(), array("admin/login", "admin/logout", "admin/register"))){
            //
        }else{
            if (Auth::guard('admin')->check() === false) {
                return redirect('/admin/login');
            }
        }

        return $next($request);
    }
}
