<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdmin extends Command
{
    protected $signature = 'ecole:create-admin';

    protected $description = 'Créer un compte administrateur';

    public function handle(): int
    {
        $name = $this->ask('Nom de l’administrateur');
        $email = $this->ask('Adresse email');
        $phone = $this->ask('Téléphone');
        $password = $this->secret('Mot de passe');

        if (!$name || !$email || !$phone || !$password) {
            $this->error('Tous les champs sont obligatoires.');
            return self::FAILURE;
        }

        if (User::where('email', $email)->exists()) {
            $this->error('Cette adresse email est déjà utilisée.');
            return self::FAILURE;
        }

        if (User::where('phone', $phone)->exists()) {
            $this->error('Ce numéro de téléphone est déjà utilisé.');
            return self::FAILURE;
        }

        User::create([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'password' => Hash::make($password),
            'role' => 'admin',
        ]);

        $this->info('Compte administrateur créé avec succès.');

        return self::SUCCESS;
    }
}
