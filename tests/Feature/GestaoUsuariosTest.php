<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GestaoUsuariosTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create(['papel' => User::PAPEL_ADMIN]);
    }

    public function test_admin_ve_a_lista_de_usuarios()
    {
        $admin = $this->admin();

        $this->actingAs($admin)->get('/adm/usuarios')->assertOk()->assertSee($admin->email);
    }

    public function test_editor_nao_acessa_usuarios_nem_ve_o_menu()
    {
        $editor = User::factory()->create(['papel' => User::PAPEL_EDITOR]);

        $this->actingAs($editor)->get('/adm/usuarios')->assertForbidden();
        $this->actingAs($editor)->get('/adm/paginas/home')->assertOk()->assertDontSee('Usuários');
    }

    public function test_admin_cria_um_editor_que_consegue_entrar()
    {
        $this->actingAs($this->admin())->post('/adm/usuarios', [
            'name' => 'Maria',
            'email' => 'maria@idtnpr.org.br',
            'papel' => 'editor',
            'password' => 'senha-forte-123',
            'password_confirmation' => 'senha-forte-123',
            'ativo' => '1',
        ])->assertRedirect('/adm/usuarios');

        auth()->logout();

        $this->post('/login-adm', ['email' => 'maria@idtnpr.org.br', 'password' => 'senha-forte-123'])
            ->assertRedirect(route('admin.dashboard'));

        $this->assertNotNull(User::where('email', 'maria@idtnpr.org.br')->first()->ultimo_login);
    }

    public function test_usuario_desativado_e_deslogado()
    {
        $editor = User::factory()->create(['papel' => User::PAPEL_EDITOR, 'ativo' => false]);

        $this->actingAs($editor)->get('/adm/paginas/home')->assertRedirect(route('login'));
        $this->assertGuest();
    }

    public function test_senha_em_branco_mantem_a_atual()
    {
        $editor = User::factory()->create(['papel' => User::PAPEL_EDITOR]);
        $senhaAntiga = $editor->password;

        $this->actingAs($this->admin())->put("/adm/usuarios/{$editor->id}", [
            'name' => 'Novo nome',
            'email' => $editor->email,
            'papel' => 'editor',
            'password' => '',
            'ativo' => '1',
        ])->assertRedirect('/adm/usuarios');

        $editor->refresh();
        $this->assertSame('Novo nome', $editor->name);
        $this->assertSame($senhaAntiga, $editor->password);
    }

    public function test_admin_nao_pode_se_desativar()
    {
        $admin = $this->admin();

        $this->actingAs($admin)->put("/adm/usuarios/{$admin->id}", [
            'name' => $admin->name,
            'email' => $admin->email,
            'papel' => 'admin',
        ])->assertSessionHasErrors('ativo');

        $this->assertTrue($admin->fresh()->ativo);
    }
}
