<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Vérifier si l'admin existe déjà
        if (!User::where('email', 'admin@ztvplus.com')->exists()) {
            User::create([
                'name' => 'Administrateur ZTVPlus',
                'email' => 'admin@ztvplus.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]);
            
            $this->command->info('Utilisateur administrateur créé avec succès !');
            $this->command->info('Email: admin@ztvplus.com');
            $this->command->info('Mot de passe: admin123');
        } else {
            $this->command->info('L\'utilisateur administrateur existe déjà.');
        }
    }
}