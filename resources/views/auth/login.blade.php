<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sistema de Estoque - Login</title>
    
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
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-fadeInUp {
            animation: fadeInUp 0.6s ease-out;
        }
        
        .bg-gradient-animated {
            background: linear-gradient(-45deg, #1a1c2c, #2a2f3f, #1e2a3a, #0f172a);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }
        
        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }
        
        .floating {
            animation: floating 3s ease-in-out infinite;
        }
        
        @keyframes floating {
            0% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-10px);
            }
            100% {
                transform: translateY(0px);
            }
        }
        
        .logo-container {
            width: 120px;
            height: 120px;
            margin: 0 auto;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            padding: 15px;
        }
        
        .logo-container img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }
        
        .input-focus-effect {
            transition: all 0.3s ease;
        }
        
        .input-focus-effect:focus {
            transform: scale(1.02);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
        }
        
        .btn-hover-effect {
            transition: all 0.3s ease;
        }
        
        .btn-hover-effect:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body class="bg-gradient-animated min-h-screen flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-black opacity-50"></div>
    
    <div class="relative w-full max-w-md animate-fadeInUp">
        <!-- Logo e Título -->
        <div class="text-center mb-8 floating">
            <div class="logo-container">
                <img src="{{ asset('images/logo.png') }}" alt="Logo">
            </div>
            <h1 class="text-4xl font-bold text-white mt-4 mb-2">Controle de Estoque</h1>
            <p class="text-white text-opacity-90">Sistema de Gestão de Inventário</p>
        </div>
        
        <!-- Formulário de Login -->
        <div class="bg-white rounded-2xl shadow-2xl p-8 backdrop-blur-sm bg-opacity-95">
            <div class="text-center mb-6">
                <h2 class="text-2xl font-semibold text-gray-800">Bem-vindo!</h2>
                <p class="text-gray-500 mt-2">Faça login para acessar o sistema</p>
            </div>
            
            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <!-- Email -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-envelope mr-2 text-indigo-500"></i>E-mail
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus 
                           class="input-focus-effect w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition duration-200"
                           placeholder="seu@email.com">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Senha -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-lock mr-2 text-indigo-500"></i>Senha
                    </label>
                    <input type="password" name="password" required 
                           class="input-focus-effect w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition duration-200"
                           placeholder="••••••••">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Lembrar-me -->
                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                        <span class="ml-2 text-sm text-gray-600">Lembrar-me</span>
                    </label>
                    
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:text-indigo-800 transition">
                            Esqueceu a senha?
                        </a>
                    @endif
                </div>
                
                <!-- Botão Login -->
                <button type="submit" 
                        class="btn-hover-effect w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold py-3 px-4 rounded-lg transition duration-200 flex items-center justify-center">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Entrar no Sistema
                </button>
            </form>
            
            <!-- Informações adicionais -->
            <div class="mt-6 pt-6 border-t border-gray-200 text-center">
                <p class="text-xs text-gray-500">
                    <i class="fas fa-shield-alt mr-1"></i>
                    Sistema seguro com criptografia de dados
                </p>
            </div>
        </div>
    </div>
</body>
</html>