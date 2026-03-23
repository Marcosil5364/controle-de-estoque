<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            ['nome' => 'Eletrônicos', 'descricao' => 'Produtos eletrônicos em geral', 'ativo' => true],
            ['nome' => 'Informática', 'descricao' => 'Computadores, periféricos e acessórios', 'ativo' => true],
            ['nome' => 'Escritório', 'descricao' => 'Materiais e equipamentos para escritório', 'ativo' => true],
            ['nome' => 'Limpeza', 'descricao' => 'Produtos de limpeza e conservação', 'ativo' => true],
            ['nome' => 'Alimentação', 'descricao' => 'Produtos alimentícios', 'ativo' => true],
            ['nome' => 'Vestuário', 'descricao' => 'Roupas e acessórios', 'ativo' => true],
            ['nome' => 'Ferramentas', 'descricao' => 'Ferramentas manuais e elétricas', 'ativo' => true],
            ['nome' => 'Móveis', 'descricao' => 'Móveis em geral', 'ativo' => true],
        ];
        
        foreach ($categorias as $categoria) {
            Categoria::create($categoria);
        }
    }
}