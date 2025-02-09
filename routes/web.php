<?php

use App\Http\Controllers\GestaoLivrosController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('app');
});

Route::get('/imagem/{idAutor}/{idLivro}', [GestaoLivrosController::class, 'exibirImagem'])->name('imagem.show');