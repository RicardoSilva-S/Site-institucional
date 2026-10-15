<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\AdminUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminUserSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_cria_o_admin_com_a_senha_do_config()
    {
        config(['admin.email' => 'chefe@idtnpr.org.br', 'admin.password' => 'senha-do-env-123']);

        $this->seed(AdminUserSeeder::class);

        $admin = User::where('email', 'chefe@idtnpr.org.br')->firstOrFail();
        $this->assertTrue($admin->ehAdmin());
        $this->assertTrue($admin->ativo);
        $this->assertTrue(Hash::check('senha-do-env-123', $admin->password));
    }

    public function test_novo_deploy_nao_desfaz_a_senha_trocada_no_painel()
    {
        config(['admin.email' => 'chefe@idtnpr.org.br', 'admin.password' => 'senha-do-env-123']);
        $this->seed(AdminUserSeeder::class);

        $admin = User::where('email', 'chefe@idtnpr.org.br')->firstOrFail();
        $admin->update(['password' => Hash::make('senha-nova-do-painel')]);

        $this->seed(AdminUserSeeder::class); // simula o proximo deploy

        $this->assertTrue(Hash::check('senha-nova-do-painel', $admin->fresh()->password));
    }

    public function test_novo_deploy_reativa_o_admin_principal()
    {
        config(['admin.email' => 'chefe@idtnpr.org.br']);
        $this->seed(AdminUserSeeder::class);

        User::where('email', 'chefe@idtnpr.org.br')->update(['ativo' => false, 'papel' => 'editor']);

        $this->seed(AdminUserSeeder::class);

        $admin = User::where('email', 'chefe@idtnpr.org.br')->firstOrFail();
        $this->assertTrue($admin->ativo);
        $this->assertTrue($admin->ehAdmin());
    }
}
