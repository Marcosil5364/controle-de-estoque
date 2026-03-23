<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notas_fiscais', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo', ['entrada', 'saida']);
            $table->string('numero', 20);
            $table->string('serie', 10)->nullable();
            $table->string('chave_acesso', 44)->nullable()->unique();
            $table->date('data_emissao');
            $table->date('data_entrada_saida')->nullable();
            $table->decimal('valor_total', 12, 2);
            $table->decimal('base_calculo_icms', 12, 2)->nullable();
            $table->decimal('valor_icms', 12, 2)->nullable();
            $table->decimal('base_calculo_icms_st', 12, 2)->nullable();
            $table->decimal('valor_icms_st', 12, 2)->nullable();
            $table->decimal('valor_ipi', 12, 2)->nullable();
            $table->decimal('valor_pis', 12, 2)->nullable();
            $table->decimal('valor_cofins', 12, 2)->nullable();
            $table->unsignedBigInteger('fornecedor_id')->nullable();
            $table->text('observacoes')->nullable();
            $table->string('arquivo_xml')->nullable();
            $table->unsignedBigInteger('usuario_id');
            $table->timestamps();

            $table->foreign('fornecedor_id')->references('id')->on('fornecedores')->onDelete('set null');
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notas_fiscais');
    }
};