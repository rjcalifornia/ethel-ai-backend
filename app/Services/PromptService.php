<?php

namespace App\Services;

use App\Models\AppTokens;
use Carbon\Carbon;

use App\Models\Querys;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class PromptService
{
    public function registerPromptResults($request, $respuesta, $model, $app){

        $total = $respuesta["prompt_eval_count"] + $respuesta["eval_count"];
            
           try {
            $query = new Querys;
            $appTokens = AppTokens::where('app_id', $app->id)->where('active', true)->first();
            $query->app_id = $app->id;
            $query->prompt = $request->get('pregunta');
            $query->model_response = $respuesta["response"];
            $query->prompt_token_count  = $respuesta["prompt_eval_count"];
            $query->response_token_count = $respuesta["eval_count"];
            $query->total_tokens_used = $total;
            $query->model_name = $model;
            $query->save();

            $remainingTokens = $appTokens->tokens_allocated - ($respuesta["prompt_eval_count"] + $respuesta["eval_count"]);
            $appTokens->tokens_allocated = $remainingTokens;
            $appTokens->save();

           } catch (\Throwable $th) {
            Log::critical($th);
                throw $th;
           }

    }

    public function tokenCount(){
        
    }

    public function actionAi($request, ){
        $actions = ['envia correo', 'escribe un correo', 'felicitando', 'jefe'];

        $detectAction = Str::contains($request->get('pregunta'), $actions);

        if($detectAction){
            return true;
        }

        return false;
    }
    
    
}