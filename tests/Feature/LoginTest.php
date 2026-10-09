<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Entrada e saída do painel (/login-adm e /adm/sair).
 * O limite de tentativas fica em LoginThrottleTest.
 */
class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_tela_de_login_abre(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertSee('Entrar no painel');
    }

    public function test_sair_desloga_e_o_painel_volta_a_pedir_login(): void
    {
        $this->actingAs(User::factory()->create());

        $this->post(route('admin.logout'))->assertRedirect(route('login'));

        $this->assertGuest();
        $this->get(route('admin.dashboard'))->assertRedirect(route('login'));
    }

    public function test_quem_ja_esta_logado_e_mandado_para_o_painel(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('login'))
            ->assertRedirect('/adm');
    }

    public function test_campos_vazios_mostram_erro_sem_tentar_entrar(): void
    {
        $this->from(route('login'))
            ->post(route('login.attempt'), ['email' => '', 'password' => ''])
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors(['email', 'password']);

        $this->assertGuest();
    }

    public function test_email_em_formato_invalido_mostra_erro(): void
    {
        $this->from(route('login'))
            ->post(route('login.attempt'), ['email' => 'nao-e-um-email', 'password' => 'qualquer'])
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }
}
