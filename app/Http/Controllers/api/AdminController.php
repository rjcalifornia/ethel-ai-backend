<?php

namespace App\Http\Controllers\api;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Services\AdminService;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $adminService;
    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }
    public function appRegistration(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['message' => 'No se puede procesar la solicitud. Faltan campos'], 422);
        }

        $app = $this->adminService->create($request);

        return response()->json([$app]);
    }
}
