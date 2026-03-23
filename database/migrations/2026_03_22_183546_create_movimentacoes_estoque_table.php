<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('movimentacoes_estoque', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produto_id')->constrained('produtos')->onDelete('cascade');
            $table->foreignId('usuario_id')->nullable()->constrained('users')->onDelete('set null');
            $table->enum('tipo', ['entrada', 'saida']);
            $table->integer('quantidade');
            $table->decimal('valor_unitario', 10, 2)->nullable();
            $table->decimal('valor_total', 12, 2)->nullable();
            $table->string('motivo')->nullable();
            $table->dateTime('data_movimentacao');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimentacoes_estoque');
    }
};