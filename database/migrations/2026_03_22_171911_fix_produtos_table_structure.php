<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Verificar e adicionar colunas faltantes na tabela produtos
        Schema::table('produtos', function (Blueprint $table) {
            if (!Schema::hasColumn('produtos', 'quantidade_atual')) {
                $table->integer('quantidade_atual')->default(0)->after('estoque_maximo');
            }
            
            if (!Schema::hasColumn('produtos', 'estoque_minimo')) {
                $table->integer('estoque_minimo')->default(0)->after('preco_promocional');
            }
            
            if (!Schema::hasColumn('produtos', 'estoque_maximo')) {
                $table->integer('estoque_maximo')->default(0)->after('estoque_minimo');
            }
            
            if (!Schema::hasColumn('produtos', 'unidade_medida')) {
                $table->string('unidade_medida', 10)->default('UN')->after('quantidade_atual');
            }
            
            if (!Schema::hasColumn('produtos', 'localizacao')) {
                $table->string('localizacao')->nullable()->after('unidade_medida');
            }
            
            if (!Schema::hasColumn('produtos', 'preco_compra')) {
                $table->decimal('preco_compra', 12, 2)->default(0)->after('sku');
            }
            
            if (!Schema::hasColumn('produtos', 'preco_venda')) {
                $table->decimal('preco_venda', 12, 2)->default(0)->after('preco_compra');
            }
            
            if (!Schema::hasColumn('produtos', 'preco_promocional')) {
                $table->decimal('preco_promocional', 12, 2)->nullable()->after('preco_venda');
            }
        });
        
        // Verificar e adicionar colunas na tabela categorias
        if (Schema::hasTable('categorias')) {
            Schema::table('categorias', function (Blueprint $table) {
                if (!Schema::hasColumn('categorias', 'ativo')) {
                    $table->boolean('ativo')->default(true)->after('descricao');
                }
            });
        }
        
        // Verificar e adicionar colunas na tabela fornecedores
        if (Schema::hasTable('fornecedores')) {
            Schema::table('fornecedores', function (Blueprint $table) {
                if (!Schema::hasColumn('fornecedores', 'ativo')) {
                    $table->boolean('ativo')->default(true)->after('observacoes');
                }
            });
        }
    }

    public function down(): void
    {
        // Remover as colunas adicionadas (opcional)
        Schema::table('produtos', function (Blueprint $table) {
            $columns = ['quantidade_atual', 'estoque_minimo', 'estoque_maximo', 
                        'unidade_medida', 'localizacao', 'preco_compra', 
                        'preco_venda', 'preco_promocional'];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('produtos', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};