<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Verificar se a tabela produtos existe
        if (Schema::hasTable('produtos')) {
            // Verificar se a coluna ativo já existe
            if (!Schema::hasColumn('produtos', 'ativo')) {
                Schema::table('produtos', function (Blueprint $table) {
                    $table->boolean('ativo')->default(true)->after('id');
                });
            }
        }
        
        // Verificar se a tabela categorias existe
        if (Schema::hasTable('categorias')) {
            if (!Schema::hasColumn('categorias', 'ativo')) {
                Schema::table('categorias', function (Blueprint $table) {
                    $table->boolean('ativo')->default(true)->after('nome');
                });
            }
        }
        
        // Verificar se a tabela fornecedores existe
        if (Schema::hasTable('fornecedores')) {
            if (!Schema::hasColumn('fornecedores', 'ativo')) {
                Schema::table('fornecedores', function (Blueprint $table) {
                    $table->boolean('ativo')->default(true)->after('email');
                });
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('produtos', 'ativo')) {
            Schema::table('produtos', function (Blueprint $table) {
                $table->dropColumn('ativo');
            });
        }
        
        if (Schema::hasColumn('categorias', 'ativo')) {
            Schema::table('categorias', function (Blueprint $table) {
                $table->dropColumn('ativo');
            });
        }
        
        if (Schema::hasColumn('fornecedores', 'ativo')) {
            Schema::table('fornecedores', function (Blueprint $table) {
                $table->dropColumn('ativo');
            });
        }
    }
};