<?php

namespace App\Http\Middleware;

use Closure;

class RecordLastActivedTime
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (\Auth::check()) {
            // 登录后 记录最后登录时间
            \Auth::user()->recordLastActivatedAt();
        }
        return $next($request);
    }
}
