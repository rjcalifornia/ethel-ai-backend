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
        $header = $request->header('Authorization');
        $authorized = $this->validate($header);
        if(!$authorized){
            return response()->json(["message" => "Hubo un problema al procesar su solicitud."],401);
        }

        
        return $next($request);
    }

    public function validate($header){
        $app = AuthorizedApps::where('api_key', $header)->where('active', true)->first();

        if($app){
            return true;
        }

        return false;
    }
}
