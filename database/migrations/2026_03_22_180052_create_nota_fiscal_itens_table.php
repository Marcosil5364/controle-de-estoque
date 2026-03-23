<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nota_fiscal_itens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nota_fiscal_id');
            $table->unsignedBigInteger('produto_id');
            $table->integer('quantidade');
            $table->decimal('valor_unitario', 12, 2);
            $table->decimal('valor_total', 12, 2);
            $table->decimal('desconto', 12, 2)->default(0);
            $table->timestamps();

            $table->foreign('nota_fiscal_id')->references('id')->on('notas_fiscais')->onDelete('cascade');
            $table->foreign('produto_id')->references('id')->on('produtos')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nota_fiscal_itens');
    }
};