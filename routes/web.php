<?php

use App\Http\Controllers\GestaoLivrosController;
use Illuminate\Support\Facades\Route;

Route::get('/welcome', function(){
    return view('app');
})->name('welcome');

Route::get('/gestao-livros', [GestaoLivrosController::class, 'index'])->name('gestao-livros');

Route::post('/registra-livros', [GestaoLivrosController::class, 'registraLivro'])->name('registra-livros');

Route::delete('/deleta-livro/{id}', [GestaoLivrosController::class, 'deletaLivro'])->name('deleta-livro');

Route::put('/editar-livro', [GestaoLivrosController::class, 'editarLivro'])->name('editar-livro');

Route::get('/imagem/{idAutor}/{idLivro}', [GestaoLivrosController::class, 'exibirImagem'])->name('imagem.show');