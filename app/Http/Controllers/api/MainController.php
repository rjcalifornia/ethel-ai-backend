<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Querys;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function promptQuery(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pregunta' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'No se puede procesar la solicitud. Faltan campos'], 422);
        }

        try {
            $respuesta = Http::timeout(495)->post(config("ai.model_url") . '/api/generate', [
                'model' => config("ai.app_model_name"),
                'prompt' => $request->get('pregunta'),
                'stream' => false
            ]);

            return response()->json(["respuesta" => $respuesta["response"]], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
 
    public function gemmaLargeModel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pregunta' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'No se puede procesar la solicitud. Faltan campos'], 422);
        }

        try {
            $respuesta = Http::timeout(495)->post(config("ai.model_url") . '/api/generate', [
                'model' => config("ai.app_model_name"),
                'prompt' => $request->get('pregunta'),
                'stream' => false
            ]);

            $total = $respuesta["prompt_eval_count"] + $respuesta["eval_count"];
            
            $query = new Querys;
            $query->app_id = 1;
            $query->prompt = $request->get('pregunta');
            $query->model_response = $respuesta["response"];
            $query->prompt_token_count  = $respuesta["prompt_eval_count"];
            $query->response_token_count = $respuesta["eval_count"];
            $query->total_tokens_used = $total;
            $query->save();

            return response()->json(["respuesta" => $respuesta["response"]], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
