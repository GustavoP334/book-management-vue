<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    protected $apiService;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    public function createOrUpdate(Request $request, $id = null)
    {
        $data = $request->validate([
            'nome' => 'required|string',
            'estado' => 'required|string'
        ]);
    
        $resultado = $this->apiService->createOrUpdate($data, $id);
    
        if (isset($resultado['error'])) {
            return response()->json([$resultado["error"]], $resultado['status']);
        }
    
        return response()->json($resultado, 200);
    }

    public function delete($id)
    {
        $resultado = $this->apiService->delete($id);

        if (isset($resultado['error'])) {
            return response()->json([$resultado["error"]], $resultado['status']);
        }
    
        return response()->json($resultado, 200);
    }

    public function get()
    {
        return response()->json($this->apiService->getAutor());
    }

    public function getLivrosAutor($id)
    {
        return response()->json($this->apiService->getLivrosAutor($id));
    }
}