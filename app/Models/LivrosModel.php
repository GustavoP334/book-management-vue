<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LivrosModel extends Model
{
    use HasFactory;

    protected $table = 'livros';
    
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'titulo',
        'descricao',
        'data_publicacao',
        'autor_id'
    ];

    public function autor()
    {
        return $this->belongsTo(AutoresModel::class, 'autor_id', 'id');
    }
}
