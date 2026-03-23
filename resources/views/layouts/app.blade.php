<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistema de Estoque')</title>
    
    <!-- Favicon - Ícone da guia do navegador -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* Animações e transições */
        .sidebar-item {
            transition: all 0.3s ease;
            border-radius: 0.75rem;
            margin-bottom: 0.25rem;
        }
        
        .sidebar-item:hover {
            transform: translateX(8px);
            background: linear-gradient(90deg, #f9fafb 0%, #ffffff 100%);
        }
        
        .sidebar-item.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white !important;
        }
        
        .sidebar-item.active i,
        .sidebar-item.active span {
            color: white !important;
        }
        
        .sidebar-item.active .icon-wrapper {
            background: rgba(255, 255, 255, 0.2) !important;
        }
        
        .bg-gradient-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .logo-small {
            width: 32px;
            height: 32px;
            object-fit: contain;
        }
        
        .logo-sidebar {
            max-height: 50px;
            width: auto;
            object-fit: contain;
        }
        
        /* Estilos para os wrappers de ícones */
        .icon-wrapper {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 12px;
            margin-right: 12px;
            transition: all 0.3s ease;
        }
        
        .sidebar-item:hover .icon-wrapper {
            transform: scale(1.05);
        }
        
        /* Cores dos ícones */
        .icon-dashboard { background: rgba(59, 130, 246, 0.15); color: #3b82f6; }
        .icon-categorias { background: rgba(16, 185, 129, 0.15); color: #10b981; }
        .icon-fornecedores { background: rgba(245, 158, 11, 0.15); color: #f59e0b; }
        .icon-produtos { background: rgba(139, 92, 246, 0.15); color: #8b5cf6; }
        .icon-movimentacoes { background: rgba(236, 72, 153, 0.15); color: #ec489a; }
        .icon-notas { background: rgba(239, 68, 68, 0.15); color: #ef4444; }
        .icon-usuarios { background: rgba(6, 182, 212, 0.15); color: #06b6d4; }
        .icon-perfil { background: rgba(107, 114, 128, 0.15); color: #6b7280; }
        
        /* Cards animados */
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.02);
        }
        
        /* Scrollbar personalizada */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-100">
    <!-- Top Navigation -->
    <nav class="bg-gradient-header text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="shrink-0 flex items-center">
                        <a href="{{ route('dashboard') }}" class="text-xl font-bold flex items-center space-x-2">
                            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo-small">
                            <span>Controle de Estoque</span>
                        </a>
                    </div>
                </div>
                
                @auth
                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 rounded-full bg-white bg-opacity-20 flex items-center justify-center">
                            <i class="fas fa-user-circle text-white"></i>
                        </div>
                        <span class="text-sm font-medium">{{ Auth::user()->name }}</span>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm hover:text-gray-200 transition flex items-center space-x-1 px-3 py-2 rounded-lg hover:bg-white hover:bg-opacity-10">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Sair</span>
                        </button>
                    </form>
                </div>
                @endauth
            </div>
        </div>
    </nav>
    
    <div class="flex">
        <!-- Sidebar -->
        @auth
        <div class="w-72 bg-white shadow-xl min-h-screen">
            <div class="p-5 border-b border-gray-100">
                <div class="flex items-center justify-center">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo-sidebar">
                </div>
            </div>
            <nav class="mt-4 px-3">
                <div class="space-y-1">
                    <!-- Dashboard -->
                    <a href="{{ route('dashboard') }}" class="sidebar-item flex items-center px-3 py-2.5 text-sm font-medium rounded-xl {{ request()->routeIs('dashboard') ? 'active' : 'text-gray-600 hover:bg-gray-50' }}">
                        <span class="icon-wrapper icon-dashboard">
                            <i class="fas fa-chart-line text-lg"></i>
                        </span>
                        <span>Dashboard</span>
                    </a>
                    
                    <div class="pt-4 pb-2">
                        <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider flex items-center">
                            <i class="fas fa-database mr-2 text-xs"></i>
                            Cadastros
                        </p>
                    </div>
                    
                    <!-- Categorias -->
                    <a href="{{ route('categorias.index') }}" class="sidebar-item flex items-center px-3 py-2.5 text-sm font-medium rounded-xl {{ request()->routeIs('categorias.*') ? 'active' : 'text-gray-600 hover:bg-gray-50' }}">
                        <span class="icon-wrapper icon-categorias">
                            <i class="fas fa-tags text-lg"></i>
                        </span>
                        <span>Categorias</span>
                    </a>
                    
                    <!-- Fornecedores -->
                    <a href="{{ route('fornecedores.index') }}" class="sidebar-item flex items-center px-3 py-2.5 text-sm font-medium rounded-xl {{ request()->routeIs('fornecedores.*') ? 'active' : 'text-gray-600 hover:bg-gray-50' }}">
                        <span class="icon-wrapper icon-fornecedores">
                            <i class="fas fa-truck-moving text-lg"></i>
                        </span>
                        <span>Fornecedores</span>
                    </a>
                    
                    <!-- Produtos -->
                    <a href="{{ route('produtos.index') }}" class="sidebar-item flex items-center px-3 py-2.5 text-sm font-medium rounded-xl {{ request()->routeIs('produtos.*') ? 'active' : 'text-gray-600 hover:bg-gray-50' }}">
                        <span class="icon-wrapper icon-produtos">
                            <i class="fas fa-cubes text-lg"></i>
                        </span>
                        <span>Produtos</span>
                    </a>
                    
                    <div class="pt-4 pb-2">
                        <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider flex items-center">
                            <i class="fas fa-exchange-alt mr-2 text-xs"></i>
                            Movimentações
                        </p>
                    </div>
                    
                    <!-- Movimentações -->
                    <a href="{{ route('estoque.movimentacoes') }}" class="sidebar-item flex items-center px-3 py-2.5 text-sm font-medium rounded-xl {{ request()->routeIs('estoque.movimentacoes') ? 'active' : 'text-gray-600 hover:bg-gray-50' }}">
                        <span class="icon-wrapper icon-movimentacoes">
                            <i class="fas fa-arrows-spin text-lg"></i>
                        </span>
                        <span>Movimentações</span>
                    </a>
                    
                    <!-- Notas Fiscais -->
                    <a href="{{ route('notas-fiscais.index') }}" class="sidebar-item flex items-center px-3 py-2.5 text-sm font-medium rounded-xl {{ request()->routeIs('notas-fiscais.*') ? 'active' : 'text-gray-600 hover:bg-gray-50' }}">
                        <span class="icon-wrapper icon-notas">
                            <i class="fas fa-file-invoice-dollar text-lg"></i>
                        </span>
                        <span>Notas Fiscais</span>
                    </a>
                    
                    <div class="pt-4 pb-2">
                        <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider flex items-center">
                            <i class="fas fa-cog mr-2 text-xs"></i>
                            Configurações
                        </p>
                    </div>
                    
                    <!-- Usuários -->
                    <a href="{{ route('users.index') }}" class="sidebar-item flex items-center px-3 py-2.5 text-sm font-medium rounded-xl {{ request()->routeIs('users.*') ? 'active' : 'text-gray-600 hover:bg-gray-50' }}">
                        <span class="icon-wrapper icon-usuarios">
                            <i class="fas fa-users text-lg"></i>
                        </span>
                        <span>Usuários</span>
                    </a>
                    
                    <!-- Perfil -->
                    <a href="{{ route('profile.edit') }}" class="sidebar-item flex items-center px-3 py-2.5 text-sm font-medium rounded-xl {{ request()->routeIs('profile.*') ? 'active' : 'text-gray-600 hover:bg-gray-50' }}">
                        <span class="icon-wrapper icon-perfil">
                            <i class="fas fa-user-gear text-lg"></i>
                        </span>
                        <span>Meu Perfil</span>
                    </a>
                </div>
            </nav>
        </div>
        @endauth
        
        <!-- Main Content -->
        <div class="flex-1 p-6">
            @if(session('success'))
                <div class="mb-4 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded-lg shadow-sm" role="alert">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-500 text-xl"></i>
                        </div>
                        <div class="ml-3">
                            <span>{{ session('success') }}</span>
                        </div>
                    </div>
                </div>
            @endif
            
            @if(session('error'))
                <div class="mb-4 bg-gradient-to-r from-red-50 to-rose-50 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded-lg shadow-sm" role="alert">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-500 text-xl"></i>
                        </div>
                        <div class="ml-3">
                            <span>{{ session('error') }}</span>
                        </div>
                    </div>
                </div>
            @endif
            
            @yield('content')
        </div>
    </div>
</body>
</html>