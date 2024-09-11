<?php

namespace App\Http\Middleware;

use App\Models\AppTokens;
use App\Models\AuthorizedApps;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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

        $request->merge(['client_id' => $clientId]);

        return $next($request);
    }

    public function validate($clientId, $apiKey)
    {
        $app = AuthorizedApps::where('client_id', $clientId)->where('active', true)->first();

        if (! $app || ! password_verify($apiKey, $app->api_key)) {
            return false;
        }

        $appTokens = AppTokens::where('app_id', $app->id)->where('active', true)->first();
 
        if($appTokens->tokens_allocated < 20){
            return false;
        }

        return true;
    }
}
