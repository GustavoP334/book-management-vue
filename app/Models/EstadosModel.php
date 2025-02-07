<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadosModel extends Model
{
    use HasFactory;

    protected $table = 'estados';
    
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'estado',
        'sigla'
    ];

    public function autores()
    {
        return $this->hasMany(AutoresModel::class, 'estado_id');
    }
}
