<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        if (auth()->check()) {
            // Vérifiez si l'utilisateur est un administrateur
            if (auth()->user()->isAdmin()) {
                return $next($request);
            }
            // Si l'utilisateur n'est pas administrateur, renvoyez à la page d'accueil ou autre
            return redirect('/');
        }

        return redirect('/login');
    }
}
