<?php

namespace Database\Seeders;

use App\Models\AutoresModel;
use App\Models\EstadosModel;
use Illuminate\Database\Seeder;

class AutoresSeeder extends Seeder
{
    public function run(): void
    {
        $autores = [
            ['nome' => 'Machado de Assis', 'estado_id' => 'Rio de Janeiro'],
            ['nome' => 'Clarice Lispector', 'estado_id' => 'Paraíba'],
            ['nome' => 'Jorge Amado', 'estado_id' => 'Bahia'],
            ['nome' => 'Monteiro Lobato', 'estado_id' => 'São Paulo'],
            ['nome' => 'Graciliano Ramos', 'estado_id' => 'Alagoas'],
            ['nome' => 'Carlos Drummond de Andrade', 'estado_id' => 'Minas Gerais'],
            ['nome' => 'Rachel de Queiroz', 'estado_id' => 'Ceará'],
            ['nome' => 'Lygia Fagundes Telles', 'estado_id' => 'São Paulo'],
            ['nome' => 'Nelson Rodrigues', 'estado_id' => 'Rio de Janeiro'],
            ['nome' => 'Manuel Bandeira', 'estado_id' => 'PE']
        ];

        foreach ($autores as $autor) {
            $idEstado = EstadosModel::where('estado', $autor['estado_id'])->first('id');

            if(!is_null($idEstado)){
                $autor['estado_id'] = $idEstado->id;
                AutoresModel::firstOrCreate($autor);
            }
        }
    }
}
