
<?php

namespace App\Services;
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
            $clientId = Str::uuid()->toString();
            $apiKey = Str::uuid()->toString();
            DB::transaction(function () use ($request, $app, $clientId, $apiKey) {
                $app->name = $request->get('name');
                $app->client_id = $clientId;
                $app->api_key = bcrypt($apiKey);
                $app->active = true;
                $app->id_rol = 1;
                $app->save();
              
            });

            return ['client_id' => $clientId, 'api_key' => $apiKey];
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}