<?php

namespace App\Http\Middleware;

use App\Models\AuthorizedApps;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AppValidation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $clientId = $request->header('Client');
        $apiKey = $request->header('Authorization');
        $authorized = $this->validate($clientId, $apiKey);
        if (!$authorized) {
            return response()->json(["message" => "Hubo un problema al procesar su solicitud."], 401);
        }


        return $next($request);
    }

    public function validate($clientId, $apiKey)
    {
        $app = AuthorizedApps::where('client_id', $clientId)->where('active', true)->first();

        if (! $app || ! password_verify($apiKey, $app->api_key)) {
            return false;
        }


        return true;
    }
}
