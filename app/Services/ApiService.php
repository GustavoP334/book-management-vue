<?php

namespace App\Services;

use App\Models\AutoresModel;
use App\Models\EstadosModel;
use App\Models\LivrosModel;
use Symfony\Component\HttpFoundation\Response;

class ApiService
{
    public function createOrUpdate(array $data, $id = null)
    {
        $estado = EstadosModel::where('estado', $data['estado'])
        ->orWhere('sigla', $data['estado'])
        ->first();

        if (!$estado) {
            return [
                'error' => 'Estado inexistente.',
                'status' => Response::HTTP_NOT_FOUND
            ];
        }

        try {
            $autor = AutoresModel::updateOrCreate(
                ['id' => $id],
                [
                    'nome' => $data['nome'],
                    'estado_id' => $estado->id
                ]
            );

            return $autor->wasRecentlyCreated ? ['message' => 'Autor Criado'] : ['message' => 'Autor atualizado.'];
        } catch (\Throwable $th) {
            return [
                'error' => 'Erro ao criar autor.',
                'status' => Response::HTTP_NOT_FOUND
            ];
        }
    }

    public function delete($id)
    {
        $writerHasBooks = LivrosModel::where('autor_id', $id)->exists();

        if($writerHasBooks){
            return ['error' => 'Autor possui livros associados.', 'status' => Response::HTTP_NOT_FOUND];
        }

        try {
            AutoresModel::find($id)->delete();

            return 'Autor excluido com sucesso.';
        } catch (\Throwable $th) {
            return ['error' => 'Autor possui livros associados.', 'status' => Response::HTTP_NOT_FOUND];
        }
    }

    public function getAutor()
    {
        $autores = AutoresModel::select('autores.id', 'autores.nome', 'estados.estado')
        ->join('estados', 'estados.id', '=', 'autores.estado_id')
        ->get()
        ->toArray();

        return $autores;
    }

    public function getLivrosAutor($id)
    {
        return LivrosModel::select('titulo', 'descricao', 'data_publicacao')->where('autor_id', $id)->get()->toArray();
    }
}