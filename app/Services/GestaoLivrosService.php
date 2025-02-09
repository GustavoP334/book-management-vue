<?php

namespace App\Services;

use App\Models\AutoresModel;
use App\Models\LivrosModel;
use Log;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\File;

class GestaoLivrosService
{
    public function listarLivros($page)
    {
        return LivrosModel::with('autor')->paginate(10, ['*'], 'page', $page);
    }

    public function getWritters()
    {
        return AutoresModel::get()->all();
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

            return [
                'success' => 'Livro deletado com sucesso.',
                'status' => Response::HTTP_ACCEPTED
            ];
        } catch (\Throwable $th) {
            return [
                'error' => 'Erro ao deletar livro.',
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR
            ];
        }
    }

    public function registraOuAtualizaLivro($id = null, $titulo, $descricao, $autor, $dataPublicacao, $capa)
    {
        $dados =[
            'titulo' => $titulo,
            'autor_id' => $autor,
            'descricao' => $descricao,
            'data_publicacao' => $dataPublicacao
        ];

        if ($id !== null) {
            $dados['id'] = $id;
        }
        try {
            $livro = LivrosModel::updateOrCreate(
                $dados
            );

            if(!is_null($capa)){
                $this->salvaArquivo($capa, $autor, $livro->id);
            }

            $isUpdated = $livro->wasRecentlyCreated ? 'criado' : 'atualizado';

            return [
                'success' => 'Livro '.$isUpdated.' com sucesso.',
                'status' => Response::HTTP_ACCEPTED
            ];
        } catch (\Throwable $th) {
            return [
                'error' => 'Erro ao atualizar livro.' . $th->getMessage(),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR
            ];
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
            return;
        }

        abort(404);
    }
}