<?php

namespace App\Services;
use App\Models\AppTokens;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;
use App\Models\AuthorizedApps;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class AdminService
{
    public function create($request){
        try {
            $app = new AuthorizedApps();
            $appTokens = new AppTokens();
            $clientId = Str::uuid()->toString();
            $apiKey = Str::uuid()->toString();
            DB::transaction(function () use ($request, $app, $clientId, $apiKey, $appTokens) {
                $app->name = $request->get('name');
                $app->client_id = $clientId;
                $app->api_key = bcrypt($apiKey);
                $app->active = true;
                $app->role_id = 1;
                $app->save();

                $appTokens->app_id = $app->id;
                $appTokens->tokens_allocated = 100000;
                $appTokens->active = true;
                $appTokens->save();
              
            });

            return ['client_id' => $clientId, 'api_key' => $apiKey];
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}