<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 150);
            $table->text('descricao')->nullable();
            $table->string('codigo_barras', 50)->nullable()->unique();
            $table->string('sku', 50)->nullable()->unique();
            $table->decimal('preco_compra', 12, 2)->default(0);
            $table->decimal('preco_venda', 12, 2)->default(0);
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
        Schema::dropIfExists('produtos');
    }
};