<?php

namespace Database\Seeders;

use App\Models\EstadosModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EstadosSeeder extends Seeder
{
    public function run(): void
    {
        $estados = [
            ['estado' => 'Minas Gerais', 'sigla' => 'MG'],
            ['estado' => 'São Paulo', 'sigla' => 'SP'],
            ['estado' => 'Rio de Janeiro', 'sigla' => 'RJ'],
            ['estado' => 'Paraná', 'sigla' => 'PR'],
            ['estado' => 'Goiás', 'sigla' => 'GO'],
            ['estado' => 'Bahia', 'sigla' => 'BA'],
            ['estado' => 'Ceará', 'sigla' => 'CE'],
            ['estado' => 'Distrito Federal', 'sigla' => 'DF'],
            ['estado' => 'Espírito Santo', 'sigla' => 'ES'],
            ['estado' => 'Maranhão', 'sigla' => 'MA'],
            ['estado' => 'Mato Grosso', 'sigla' => 'MT'],
            ['estado' => 'Mato Grosso do Sul', 'sigla' => 'MS'],
            ['estado' => 'Paraíba', 'sigla' => 'PB'],
            ['estado' => 'Pará', 'sigla' => 'PA'],
            ['estado' => 'Pernambuco', 'sigla' => 'PE'],
            ['estado' => 'Piauí', 'sigla' => 'PI'],
            ['estado' => 'Rio Grande do Norte', 'sigla' => 'RN'],
            ['estado' => 'Rio Grande do Sul', 'sigla' => 'RS'],
            ['estado' => 'Rondônia', 'sigla' => 'RO'],
            ['estado' => 'Roraima', 'sigla' => 'RR'],
            ['estado' => 'Santa Catarina', 'sigla' => 'SC'],
            ['estado' => 'São Paulo', 'sigla' => 'SP'],
            ['estado' => 'Sergipe', 'sigla' => 'SE'],
            ['estado' => 'Tocantins', 'sigla' => 'TO'],
            ['estado' => 'Acre', 'sigla' => 'AC'],
            ['estado' => 'Alagoas', 'sigla' => 'AL'],
            ['estado' => 'Amazonas', 'sigla' => 'AM'],
            ['estado' => 'Amapá', 'sigla' => 'AP'],
            ['estado' => 'Santa Catarina', 'sigla' => 'SC']
        ];
        
        foreach ($estados as $estado) {
            EstadosModel::firstOrCreate(
                ['sigla' => $estado['sigla']],
                ['estado' => $estado['estado']]
            );
        }
    }
}
