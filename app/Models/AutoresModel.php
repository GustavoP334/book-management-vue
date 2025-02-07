<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AutoresModel extends Model
{
    use HasFactory;

    protected $table = 'autores';
    
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'nome',
        'estado_id'
    ];

    public function estado()
    {
        return $this->belongsTo(EstadosModel::class, 'estado_id', 'id');
    }
}
