<?php

namespace Tests\Feature;

use App\Models\MembroInstitucional;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class DiretoriaConselhoTest extends TestCase
{
    use RefreshDatabase;

    private const PAINEL = '/adm/equipe';

    private function editor(): User
    {
        return User::factory()->create(['papel' => User::PAPEL_EDITOR]);
    }

    /** Foto de verdade do projeto (o PHP local não tem GD para gerar imagens falsas). */
    private function foto(string $nome = 'nova.jpg'): UploadedFile
    {
        return new UploadedFile(public_path('assets/equipe/bruno.jpg'), $nome, 'image/jpeg', null, true);
    }

    private function dados(array $extra = []): array
    {
        return array_merge([
            'grupo' => 'diretoria',
            'nome' => 'Maria Teste',
            'cargo' => 'Diretoria financeira',
            'bio' => 'Contadora com experiência no terceiro setor.',
            'ordem' => 4,
        ], $extra);
    }

    public function test_institucional_mostra_a_diretoria_e_o_conselho_do_banco(): void
    {
        $this->get(route('institucional'))
            ->assertOk()
            ->assertSee('Jonny de Souza Ribeiro')
            ->assertSee('Bruno Nascimento')
            ->assertSee('Walmir Rafael da Silva')
            ->assertSee('WS');
    }

    public function test_fotos_atuais_foram_copiadas_para_o_banco(): void
    {
        $jonny = MembroInstitucional::where('nome', 'Jonny de Souza Ribeiro')->firstOrFail();

        $this->assertTrue($jonny->temFoto());
        $this->assertTrue($jonny->foto_aproximada);

        $this->get(route('institucional'))->assertSee($jonny->fotoUrl(), false);
    }

    public function test_rota_da_foto_entrega_a_imagem_guardada_no_banco(): void
    {
        $gilmar = MembroInstitucional::where('nome', 'Gilmar Boti Júnior')->firstOrFail();

        $resposta = $this->get(route('equipe.foto', $gilmar))->assertOk();

        $this->assertSame('image/jpeg', $resposta->headers->get('Content-Type'));
        $this->assertSame(file_get_contents(public_path('assets/equipe/gilmar.jpg')), $resposta->getContent());
    }

    public function test_conselho_sem_foto_da_404_na_rota_da_foto(): void
    {
        $conselheiro = MembroInstitucional::where('grupo', 'conselho')->firstOrFail();

        $this->get(route('equipe.foto', $conselheiro))->assertNotFound();
    }

    public function test_sigla_usa_a_primeira_e_a_ultima_palavra_do_nome(): void
    {
        $this->assertSame('AL', (new MembroInstitucional(['nome' => 'Anderson de Jesus Ciriaco Lopes']))->sigla());
        $this->assertSame('M', (new MembroInstitucional(['nome' => 'Maria']))->sigla());
    }

    public function test_sem_login_nao_acessa_o_painel(): void
    {
        $this->get(self::PAINEL)->assertRedirect(route('login'));
    }

    public function test_painel_lista_diretoria_e_conselho(): void
    {
        $this->actingAs($this->editor())->get(self::PAINEL)
            ->assertOk()
            ->assertSee('Diretoria executiva')
            ->assertSee('Vinicius Cancian');
    }

    public function test_adiciona_pessoa_com_foto_e_ela_aparece_no_site(): void
    {
        $this->actingAs($this->editor())
            ->post(self::PAINEL, $this->dados(['foto' => $this->foto('maria.jpg')]))
            ->assertRedirect(self::PAINEL)
            ->assertSessionHasNoErrors();

        $maria = MembroInstitucional::where('nome', 'Maria Teste')->firstOrFail();
        $this->assertSame('maria.jpg', $maria->foto_nome);
        $this->assertSame('image/jpeg', $maria->foto_mime);

        $this->get(route('institucional'))
            ->assertSee('Maria Teste')
            ->assertSee('Diretoria financeira')
            ->assertSee($maria->fotoUrl(), false);
    }

    public function test_recusa_arquivo_que_nao_e_imagem(): void
    {
        $this->actingAs($this->editor())
            ->post(self::PAINEL, $this->dados([
                'foto' => UploadedFile::fake()->createWithContent('curriculo.pdf', '%PDF-1.4'),
            ]))
            ->assertSessionHasErrors('foto');

        $this->assertDatabaseMissing('membros_institucionais', ['nome' => 'Maria Teste']);
    }

    public function test_nome_e_cargo_sao_obrigatorios(): void
    {
        $this->actingAs($this->editor())
            ->post(self::PAINEL, ['grupo' => 'diretoria'])
            ->assertSessionHasErrors(['nome', 'cargo']);
    }

    public function test_edita_e_remove_a_foto(): void
    {
        $bruno = MembroInstitucional::where('nome', 'Bruno Nascimento')->firstOrFail();

        $this->actingAs($this->editor())
            ->put(self::PAINEL . "/{$bruno->id}", $this->dados([
                'nome' => 'Bruno Nascimento',
                'cargo' => 'Tecnologia',
                'remover_foto' => '1',
            ]))
            ->assertRedirect(self::PAINEL);

        $bruno->refresh();
        $this->assertSame('Tecnologia', $bruno->cargo);
        $this->assertFalse($bruno->temFoto());
        $this->assertNull($bruno->foto_data);
    }

    public function test_editar_sem_enviar_foto_mantem_a_atual(): void
    {
        $gilmar = MembroInstitucional::where('nome', 'Gilmar Boti Júnior')->firstOrFail();

        $this->actingAs($this->editor())
            ->put(self::PAINEL . "/{$gilmar->id}", $this->dados(['nome' => 'Gilmar Boti Júnior']));

        $this->assertTrue($gilmar->fresh()->temFoto());
    }

    public function test_remover_pessoa_tira_do_site(): void
    {
        $walmir = MembroInstitucional::where('nome', 'Walmir Rafael da Silva')->firstOrFail();

        $this->actingAs($this->editor())
            ->delete(self::PAINEL . "/{$walmir->id}")
            ->assertRedirect(self::PAINEL);

        $this->get(route('institucional'))->assertDontSee('Walmir Rafael da Silva');
    }
}
