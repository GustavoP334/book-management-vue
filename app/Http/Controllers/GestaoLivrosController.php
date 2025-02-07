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

    public function index()
    {
        $result = $this->gestaoLivrosService->listarLivros();

        return view('gestao.gestao-livros', $result);
    }

    public function registraLivro(Request $request)
    {
        $request->validate([
            'capa' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $response = $this->gestaoLivrosService->registraLivro($request->input('title'),
         $request->input('descricao'),
         $request->input('autor'),
         $request->input('data_publicacao'),
         $request->file('capa')
        );

        $this->makeMessage($request, $response);

        return redirect()->back();
    }

    public function deletaLivro(Request $request, $id)
    {
        $response = $this->gestaoLivrosService->deletaLivro($id);

        $this->makeMessage($request, $response);

        return redirect()->back();
    }

    public function editarLivro(Request $request)
    {
        $request->validate([
            'capa' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $response = $this->gestaoLivrosService->editarLivro($request->input('id'),
         $request->input('title'),
          $request->input('descricao'),
           $request->input('autor'),
           $request->input('data_publicacao'),
           $request->file('capa')
        );

        $this->makeMessage($request, $response);

        return redirect()->back();
    }
    
    public function exibirImagem($idAutor, $idLivro)
    {
        $this->gestaoLivrosService->exibirImagem($idAutor, $idLivro);
    }
}