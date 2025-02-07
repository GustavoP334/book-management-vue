<?php

namespace App\Services;

use App\Models\AutoresModel;
use App\Models\LivrosModel;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;

class GestaoLivrosService
{
    public function listarLivros(): array
    {
        $autores = AutoresModel::get()->all();

        $livros = LivrosModel::with('autor')->paginate(10);

        return [
            'autores' => $autores,
            'livros' => $livros
        ];
    }

    public function registraLivro($titulo, $descricao, $autor, $dataPublicacao, $capa): string
    {
        try {
            $livro = LivrosModel::firstOrCreate(
                [
                    'titulo' => $titulo,
                    'autor_id' => $autor
                ],
                [
                    'descricao' => $descricao,
                    'data_publicacao' => $dataPublicacao
                ]
            );

            $this->salvaArquivo($capa, $autor, $livro->id);

            $response = 'Livro registrado com sucesso.';
        } catch (\Throwable $th) {
            return 'Erro ao registrar livro.';
        }

        $response = !$livro->wasRecentlyCreated ? 'Livro já existe.' : $response;

        return $response;
    }

    private function salvaArquivo($arquivo, $idAutor, $idLivro)
    {
        $diretorioPadrao = env('CAPA_PATH');

        if (!is_dir($diretorioPadrao)) {
            mkdir($diretorioPadrao, 0777, true);
        }

        $diretorioAutor = $diretorioPadrao . '/' . $idAutor;

        if (!is_dir($diretorioAutor)) {
            mkdir($diretorioAutor, 0777, true);
        }

        $destinoArquivo = $diretorioAutor . '/' . $idLivro . '.jpg';

        try {
            copy($arquivo, $destinoArquivo);
            chmod($destinoArquivo, 0644);
        } catch (\Throwable $th) {
            return 'Erro ao registrar capa do livro.';
        }        
    }

    public function deletaLivro($id)
    {
        try {
            LivrosModel::destroy($id);

            return 'Livro deletado com sucesso.';
        } catch (\Throwable $th) {
            return 'Erro ao deletar livro.';
        }
    }

    public function editarLivro($id, $titulo, $descricao, $autor, $dataPublicacao, $capa)
    {
        try {
            $livro = LivrosModel::updateOrCreate(
                ['id' => $id],
                [
                    'titulo' => $titulo,
                    'autor_id' => $autor,
                    'descricao' => $descricao,
                    'data_publicacao' => $dataPublicacao
                ]
            );

            if(!is_null($capa)){
                $this->salvaArquivo($capa, $autor, $livro->id);
            }

            return 'Livro atualizado com sucesso.';
        } catch (\Throwable $th) {
            return 'Erro ao atualizar livro.';
        }
    }

    public function exibirImagem($idAutor, $idLivro)
    {
        $caminhoImagem = env('CAPA_PATH').'/'.$idAutor.'/'.$idLivro.'.jpg';

        if (File::exists($caminhoImagem)) {
            $image = file_get_contents($caminhoImagem);

            $mimeType = mime_content_type($caminhoImagem);

            header("Content-type: $mimeType");
            header("Content-Length: " . strlen($image));
            echo $image;
        }

        abort(404);
    }
}