<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Cria (ou atualiza a senha de) o usuário que acessa o painel
 * /admin/conteudo. Credenciais vêm do .env — ver .env.example:
 *
 *   ADMIN_NAME=...
 *   ADMIN_EMAIL=...
 *   ADMIN_PASSWORD=...
 *
 * Rode com: php artisan db:seed --class=AdminUserSeeder
 * (o DatabaseSeeder padrão já chama este seeder.)
 */
class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('ADMIN_EMAIL', 'admin@idtnpr.org.br');
        $password = env('ADMIN_PASSWORD', 'trocar-esta-senha');

        User::query()->updateOrCreate(
            ['email' => $email],
            [
                'name' => env('ADMIN_NAME', 'Administrador IDTNPR'),
                'password' => Hash::make($password),
                'email_verified_at' => now(),
                'papel' => User::PAPEL_ADMIN,
                'ativo' => true,
            ],
        );

        if (! $this->command) {
            return;
        }

        $this->command->info("Usuário admin pronto: {$email}");

        if (! env('ADMIN_PASSWORD')) {
            $this->command->warn(
                'ADMIN_PASSWORD não definida no .env — usando a senha padrão "trocar-esta-senha". Troque-a antes de publicar em produção.'
            );
        }
    }
}
