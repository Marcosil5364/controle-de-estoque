<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CategoriaSeeder::class,
        ]);
        
        $this->command->info('✅ Database seeding completed!');
        $this->command->info('📧 Email: admin@admin.com');
        $this->command->info('🔑 Senha: password');
    }
}