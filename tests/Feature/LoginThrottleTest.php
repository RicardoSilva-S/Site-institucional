<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginThrottleTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create([
            'email' => 'admin@exemplo.org.br',
            'password' => bcrypt('senha-correta'),
        ]);
    }

    private function tentarLogin(string $senha)
    {
        return $this->from(route('login'))->post(route('login.attempt'), [
            'email' => 'admin@exemplo.org.br',
            'password' => $senha,
        ]);
    }

    public function test_login_com_senha_correta_entra_no_painel(): void
    {
        $this->admin();

        $this->tentarLogin('senha-correta')
            ->assertRedirect(route('admin.content.edit'));

        $this->assertAuthenticated();
    }

    public function test_senha_errada_mostra_erro_sem_bloquear(): void
    {
        $this->admin();

        $this->tentarLogin('senha-errada')
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors(['email' => 'E-mail ou senha incorretos.']);

        $this->assertGuest();
    }

    public function test_bloqueia_depois_de_cinco_tentativas_erradas(): void
    {
        $this->admin();

        for ($i = 0; $i < 5; $i++) {
            $this->tentarLogin('senha-errada');
        }

        $this->tentarLogin('senha-errada')
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors('email');

        $this->assertStringContainsString(
            'Muitas tentativas de login',
            session('errors')->first('email')
        );
    }

    public function test_bloqueado_nao_entra_nem_com_a_senha_correta(): void
    {
        $this->admin();

        for ($i = 0; $i < 5; $i++) {
            $this->tentarLogin('senha-errada');
        }

        $this->tentarLogin('senha-correta');

        $this->assertGuest();
    }

    public function test_login_certo_zera_o_contador_de_erros(): void
    {
        $this->admin();

        for ($i = 0; $i < 4; $i++) {
            $this->tentarLogin('senha-errada');
        }

        $this->tentarLogin('senha-correta');
        $this->assertAuthenticated();
        $this->post(route('logout'));

        for ($i = 0; $i < 4; $i++) {
            $this->tentarLogin('senha-errada');
        }

        $this->tentarLogin('senha-correta');
        $this->assertAuthenticated();
    }
}
