<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class CanUserViewPost
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
        $post = $request->route('post');
        if ($post->published) {
            return $next($request);
        } else {
            if($request->user()){
                if($request->user()->hasRole('admin') || Auth::id() == $post->creator->id){
                    return $next($request);
                }
            }
            return redirect(RouteServiceProvider::HOME);
        }
    }
}
