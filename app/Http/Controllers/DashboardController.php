<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\MovimentacaoEstoque;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            // Total de produtos
            $totalProdutos = Produto::count();

            // Produtos com estoque baixo
            $produtosEstoqueBaixo = 0;
            if (Schema::hasColumn('produtos', 'quantidade_atual') &&
                Schema::hasColumn('produtos', 'estoque_minimo')) {
                $produtosEstoqueBaixo = Produto::whereRaw('quantidade_atual <= estoque_minimo')->count();
            }

            // Valor do estoque
            $valorEstoque = 0;
            if (Schema::hasColumn('produtos', 'quantidade_atual') &&
                Schema::hasColumn('produtos', 'preco_venda')) {
                $valorEstoque = Produto::sum(DB::raw('quantidade_atual * preco_venda'));
            }

            // Últimas movimentações
            $ultimasMovimentacoes = collect();
            if (Schema::hasTable('movimentacoes_estoque')) {
                $ultimasMovimentacoes = MovimentacaoEstoque::with(['produto', 'usuario'])
                    ->latest()
                    ->limit(10)
                    ->get();
            }

            // Movimentações de hoje
            $entradasHoje = 0;
            $saidasHoje = 0;
            if (Schema::hasTable('movimentacoes_estoque')) {
                $entradasHoje = MovimentacaoEstoque::where('tipo', 'entrada')
                    ->whereDate('data_movimentacao', today())
                    ->sum('quantidade');

                $saidasHoje = MovimentacaoEstoque::where('tipo', 'saida')
                    ->whereDate('data_movimentacao', today())
                    ->sum('quantidade');
            }

            // Buscar produtos para os modais
            $produtos = Produto::orderBy('nome')->get();

            return view('dashboard', compact(
                'totalProdutos',
                'produtosEstoqueBaixo',
                'valorEstoque',
                'ultimasMovimentacoes',
                'entradasHoje',
                'saidasHoje',
                'produtos'
            ));

        } catch (\Exception $e) {
            // Se houver erro, retorna valores padrão
            $produtos = Produto::orderBy('nome')->get();

            return view('dashboard', [
                'totalProdutos' => 0,
                'produtosEstoqueBaixo' => 0,
                'valorEstoque' => 0,
                'ultimasMovimentacoes' => collect(),
                'entradasHoje' => 0,
                'saidasHoje' => 0,
                'produtos' => $produtos
            ])->with('error', 'Erro ao carregar dashboard: ' . $e->getMessage());
        }
    }
}
