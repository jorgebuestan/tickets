<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminBasicAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = (string) $request->getUser();
        $password = (string) $request->getPassword();

        if (! hash_equals((string) config('admin.user'), $user)
            || ! hash_equals((string) config('admin.password'), $password)) {
            return response('Autenticacion requerida.', 401, [
                'WWW-Authenticate' => 'Basic realm="Tickets Alfa"',
            ]);
        }

        return $next($request);
    }
}
