<?php

namespace App\Services;
use Carbon\Carbon;

use App\Models\Querys;
use App\Models\AuthorizedApps;
use Illuminate\Support\Facades\Log;


class PromptService
{
    public function registerPromptResults($request, $respuesta, $model){

        $total = $respuesta["prompt_eval_count"] + $respuesta["eval_count"];
            
           try {
            $query = new Querys;
            $query->app_id = 1;
            $query->prompt = $request->get('pregunta');
            $query->model_response = $respuesta["response"];
            $query->prompt_token_count  = $respuesta["prompt_eval_count"];
            $query->response_token_count = $respuesta["eval_count"];
            $query->total_tokens_used = $total;
            $query->model_name = $model;
            $query->save();
           } catch (\Throwable $th) {
                throw $th;
           }

    }
}