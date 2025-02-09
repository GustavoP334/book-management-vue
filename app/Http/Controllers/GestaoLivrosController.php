<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\GestaoLivrosService;
use Illuminate\Http\Request;

class GestaoLivrosController extends Controller
{
    protected $gestaoLivrosService;

    public function __construct(GestaoLivrosService $gestaoLivrosService)
    {
        $this->gestaoLivrosService = $gestaoLivrosService;
    }

    public function index(Request $request)
    {
        $result = $this->gestaoLivrosService->listarLivros($request->page);

        return response()->json($result, 200);
    }

    public function getWritters()
    {
        $result = $this->gestaoLivrosService->getWritters();

        return response()->json($result, 200);
    }

    public function registraLivro(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:191',
            'descricao' => 'required|string|max:191',
            'autor' => 'required',
            'data_publicacao' => 'required|date',
            'capa' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $id = $request->input('id') !== 'null' ? $request->input('id') : null;

        $response = $this->gestaoLivrosService->registraOuAtualizaLivro(
            $id,
            $request->input('title'),
         $request->input('descricao'),
         $request->input('autor'),
         $request->input('data_publicacao'),
            $request->file('capa')
        );

        return response()->json($response, 200);
    }

    public function deletaLivro(Request $request, $id)
    {
        $response = $this->gestaoLivrosService->deletaLivro($id);

        if (isset($response['error'])) {
            return response()->json([$response["error"]], $response['status']);
        }
    
        return response()->json($response, 200);
    }
    
    public function exibirImagem($idAutor, $idLivro)
    {
        $this->gestaoLivrosService->exibirImagem($idAutor, $idLivro);
    }
}