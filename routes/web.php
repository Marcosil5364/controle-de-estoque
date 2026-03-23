<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\FornecedorController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\MovimentacaoEstoqueController;
use App\Http\Controllers\NotaFiscalController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Categorias
    Route::resource('categorias', CategoriaController::class);
    
    // Fornecedores
    Route::resource('fornecedores', FornecedorController::class);
    
    // Produtos
    Route::resource('produtos', ProdutoController::class);
    
    // Movimentações de Estoque
    Route::get('/estoque/movimentacoes', [MovimentacaoEstoqueController::class, 'index'])
        ->name('estoque.movimentacoes');
    Route::post('/estoque/entrada', [MovimentacaoEstoqueController::class, 'entrada'])
        ->name('estoque.entrada');
    Route::post('/estoque/saida', [MovimentacaoEstoqueController::class, 'saida'])
        ->name('estoque.saida');
    Route::post('/estoque/ajuste', [MovimentacaoEstoqueController::class, 'ajuste'])
        ->name('estoque.ajuste');
    
    // Notas Fiscais
    Route::resource('notas-fiscais', NotaFiscalController::class);
    Route::post('/notas-fiscais/{nota_fiscal}/processar', [NotaFiscalController::class, 'processar'])
        ->name('notas-fiscais.processar');

    // Rotas de usuários
    Route::resource('users', UserController::class);
});

require __DIR__.'/auth.php';