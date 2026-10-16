<?php
namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class ResetAdminPassword extends Command
{
    protected $signature = 'ecole:reset-admin-password';

    protected $description = 'Définir le mot de passe administrateur';

    public function handle(): int
    {
        $user = User::where('email', 'ecoleeden@gmail.com')
            ->where('role', 'admin')
            ->first();

        if (!$user) {
            $this->error('Compte administrateur introuvable.');
            return self::FAILURE;
        }

        $password = $this->secret('Nouveau mot de passe');
        $confirmation = $this->secret('Confirmer le mot de passe');

        if (!$password || strlen($password) < 12) {
            $this->error('Le mot de passe doit contenir au moins 12 caractères.');
            return self::FAILURE;
        }

        if ($password !== $confirmation) {
            $this->error('Les mots de passe ne correspondent pas.');
            return self::FAILURE;
        }

        $user->password = Hash::make($password);
        $user->save();

        $this->info('Mot de passe administrateur mis à jour.');

        return self::SUCCESS;
    }
}
