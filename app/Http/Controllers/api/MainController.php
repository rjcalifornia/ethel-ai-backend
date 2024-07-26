<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Querys;
use App\Services\PromptService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class MainController extends Controller
{
    protected $promptService;
    public function __construct(PromptService $promptService)
    {
        $this->promptService = $promptService;
    }
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
 
    public function ethelLargeModel(Request $request)
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

            $this->promptService->registerPromptResults($request, $respuesta, config("ai.app_model_name"));

            return response()->json(["respuesta" => $respuesta["response"]], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function ethelBasicModel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pregunta' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'No se puede procesar la solicitud. Faltan campos'], 422);
        }

        try {
            $respuesta = Http::timeout(495)->post(config("ai.model_url") . '/api/generate', [
                'model' => config("ai.basic_model_name"),
                'prompt' => $request->get('pregunta'),
                'stream' => false
            ]);

            $this->promptService->registerPromptResults($request, $respuesta, config("ai.basic_model_name"));

            return response()->json(["respuesta" => $respuesta["response"]], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
