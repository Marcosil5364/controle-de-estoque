<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Verificar se a tabela existe e recriar se necessário
        if (Schema::hasTable('produtos')) {
            // Primeiro, vamos adicionar as colunas que faltam uma por uma
            try {
                Schema::table('produtos', function (Blueprint $table) {
                    // Adicionar colunas faltantes na ordem correta
                    if (!Schema::hasColumn('produtos', 'codigo_barras')) {
                        $table->string('codigo_barras', 50)->nullable()->unique()->after('descricao');
                    }
                    
                    if (!Schema::hasColumn('produtos', 'sku')) {
                        $table->string('sku', 50)->nullable()->unique()->after('codigo_barras');
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
                    
                    if (!Schema::hasColumn('produtos', 'estoque_minimo')) {
                        $table->integer('estoque_minimo')->default(0)->after('preco_promocional');
                    }
                    
                    if (!Schema::hasColumn('produtos', 'estoque_maximo')) {
                        $table->integer('estoque_maximo')->default(0)->after('estoque_minimo');
                    }
                    
                    if (!Schema::hasColumn('produtos', 'quantidade_atual')) {
                        $table->integer('quantidade_atual')->default(0)->after('estoque_maximo');
                    }
                    
                    if (!Schema::hasColumn('produtos', 'unidade_medida')) {
                        $table->string('unidade_medida', 10)->default('UN')->after('quantidade_atual');
                    }
                    
                    if (!Schema::hasColumn('produtos', 'localizacao')) {
                        $table->string('localizacao')->nullable()->after('unidade_medida');
                    }
                    
                    if (!Schema::hasColumn('produtos', 'fornecedor_id')) {
                        $table->unsignedBigInteger('fornecedor_id')->nullable()->after('categoria_id');
                        $table->foreign('fornecedor_id')->references('id')->on('fornecedores')->onDelete('set null');
                    }
                    
                    if (!Schema::hasColumn('produtos', 'ativo')) {
                        $table->boolean('ativo')->default(true)->after('fornecedor_id');
                    }
                });
            } catch (\Exception $e) {
                // Se não conseguir adicionar as colunas, recriar a tabela
                Schema::dropIfExists('produtos');
                $this->createProdutosTable();
            }
        } else {
            $this->createProdutosTable();
        }
    }
    
    private function createProdutosTable()
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 150);
            $table->text('descricao')->nullable();
            $table->string('codigo_barras', 50)->nullable()->unique();
            $table->string('sku', 50)->nullable()->unique();
            $table->decimal('preco_compra', 12, 2);
            $table->decimal('preco_venda', 12, 2);
            $table->decimal('preco_promocional', 12, 2)->nullable();
            $table->integer('estoque_minimo')->default(0);
            $table->integer('estoque_maximo')->default(0);
            $table->integer('quantidade_atual')->default(0);
            $table->string('unidade_medida', 10)->default('UN');
            $table->string('localizacao')->nullable();
            $table->unsignedBigInteger('categoria_id');
            $table->unsignedBigInteger('fornecedor_id')->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestamps();

            $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('restrict');
            $table->foreign('fornecedor_id')->references('id')->on('fornecedores')->onDelete('set null');
        });
    }

    public function down(): void
    {
        // Não vamos dropar a tabela, apenas remover as colunas que adicionamos
        if (Schema::hasTable('produtos')) {
            Schema::table('produtos', function (Blueprint $table) {
                $columns = [
                    'codigo_barras', 'sku', 'preco_compra', 'preco_promocional',
                    'estoque_minimo', 'estoque_maximo', 'quantidade_atual',
                    'unidade_medida', 'localizacao', 'ativo'
                ];
                
                foreach ($columns as $column) {
                    if (Schema::hasColumn('produtos', $column)) {
                        $table->dropColumn($column);
                    }
                }
                
                if (Schema::hasColumn('produtos', 'fornecedor_id')) {
                    $table->dropForeign(['fornecedor_id']);
                    $table->dropColumn('fornecedor_id');
                }
            });
        }
    }
};