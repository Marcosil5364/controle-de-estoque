<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Adicionar coluna ativo em produtos se não existir
        if (!Schema::hasColumn('produtos', 'ativo')) {
            Schema::table('produtos', function (Blueprint $table) {
                $table->boolean('ativo')->default(true)->after('fornecedor_id');
            });
        }
        
        // Adicionar coluna ativo em fornecedores se não existir
        if (!Schema::hasColumn('fornecedores', 'ativo')) {
            Schema::table('fornecedores', function (Blueprint $table) {
                $table->boolean('ativo')->default(true)->after('observacoes');
            });
        }
        
        // Adicionar coluna ativo em categorias se não existir
        if (!Schema::hasColumn('categorias', 'ativo')) {
            Schema::table('categorias', function (Blueprint $table) {
                $table->boolean('ativo')->default(true)->after('descricao');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('produtos', 'ativo')) {
            Schema::table('produtos', function (Blueprint $table) {
                $table->dropColumn('ativo');
            });
        }
        
        if (Schema::hasColumn('fornecedores', 'ativo')) {
            Schema::table('fornecedores', function (Blueprint $table) {
                $table->dropColumn('ativo');
            });
        }
        
        if (Schema::hasColumn('categorias', 'ativo')) {
            Schema::table('categorias', function (Blueprint $table) {
                $table->dropColumn('ativo');
            });
        }
    }
};