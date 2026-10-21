<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Cria o usuário administrador do painel (/adm) se ele ainda não existir.
 * Dados em config/admin.php, que lê do .env (ADMIN_NAME, ADMIN_EMAIL e
 * ADMIN_PASSWORD — ver .env.example).
 *
 * Roda em todo deploy (docker/start.sh). Se o admin já existe, a senha NÃO é
 * mexida (troca de senha é pelo painel /adm/usuarios); só garante que ele
 * continua admin e ativo.
 *
 * Rode com: php artisan db:seed --class=AdminUserSeeder
 */
class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = config('admin.email');
        $senha = config('admin.password') ?: 'trocar-esta-senha';

        $admin = User::query()->firstOrNew(['email' => $email]);

        // a senha so e definida quando o admin e criado; depois disso quem manda e
        // o painel (/adm/usuarios), senao cada deploy desfaria a troca de senha
        if (! $admin->exists) {
            $admin->name = config('admin.name');
            $admin->password = Hash::make($senha);
            $admin->email_verified_at = now();
        }

        // o admin principal sempre continua admin e ativo (o painel nunca fica sem admin)
        $admin->papel = User::PAPEL_ADMIN;
        $admin->ativo = true;
        $admin->save();

        if (! $this->command) {
            return;
        }

        $this->command->info("Usuário admin pronto: {$email}");

        if (! config('admin.password')) {
            $this->command->warn(
                'ADMIN_PASSWORD não definida no .env — usando a senha padrão "trocar-esta-senha". Troque-a antes de publicar em produção.'
            );
        }
    }
}
