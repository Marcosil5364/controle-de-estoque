<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Criar usuário admin
        User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        
        // Criar usuário gerente
        User::updateOrCreate(
            ['email' => 'gerente@estoque.com'],
            [
                'name' => 'Gerente de Estoque',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        
        // Criar usuário operador
        User::updateOrCreate(
            ['email' => 'operador@estoque.com'],
            [
                'name' => 'Operador de Estoque',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        
        $this->command->info('Usuários criados com sucesso!');
        $this->command->info('Emails: admin@admin.com, gerente@estoque.com, operador@estoque.com');
        $this->command->info('Senha: password');
    }
}