<?php

namespace Tests\Feature;

use App\Models\TransparenciaDocumento;
use App\Models\TransparenciaSecao;
use Carbon\CarbonInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

/**
 * Coluna data_documento (data do documento, ex.: a data da ata) em
 * transparencia_documentos. Os documentos iniciais que já traziam
 * "dd/mm/aaaa" no começo do detalhe recebem a data pela própria migration.
 */
class TransparenciaDataDocumentoTest extends TestCase
{
    use RefreshDatabase;

    private const SECAO_INSTITUCIONAL = 'institucional';
    private const ATA_DE_FUNDACAO = 'Ata de Fundação';
    private const FORMATO_BANCO = 'Y-m-d';

    private function dataDe(string $nome): ?string
    {
        $documento = TransparenciaDocumento::where('nome', $nome)->firstOrFail();

        return $documento->data_documento ? $documento->data_documento->format(self::FORMATO_BANCO) : null;
    }

    public function test_a_coluna_existe_e_e_opcional()
    {
        $this->assertTrue(Schema::hasColumn('transparencia_documentos', 'data_documento'));

        $secao = TransparenciaSecao::where('slug', self::SECAO_INSTITUCIONAL)->firstOrFail();
        $documento = TransparenciaDocumento::create(['secao_id' => $secao->id, 'nome' => 'Documento sem data']);

        $this->assertNull($documento->fresh()->data_documento);
    }

    public function test_documentos_iniciais_com_data_no_detalhe_recebem_a_data()
    {
        $esperadas = [
            self::ATA_DE_FUNDACAO => '2025-07-11',
            'Ata da Assembleia Geral Ordinária nº 01/2026' => '2026-01-02',
            'Ata da Assembleia Geral Extraordinária nº 02/2026' => '2026-01-02',
            'Regimento Interno' => '2026-01-02',
            'Termo de Cooperação Técnica nº 001/2026 com a Compaxis Tecnologia Ltda' => '2026-08-05',
        ];

        foreach ($esperadas as $nome => $data) {
            $this->assertSame($data, $this->dataDe($nome), $nome);
        }
    }

    public function test_documentos_sem_data_no_detalhe_ficam_sem_data()
    {
        // O CNPJ tem barras e números, mas não é uma data.
        foreach (['Estatuto Social consolidado', 'Comprovante de Inscrição no CNPJ', 'Regulamento de Contratações'] as $nome) {
            $this->assertNull($this->dataDe($nome), $nome);
        }
    }

    public function test_o_texto_do_detalhe_continua_como_estava()
    {
        $ata = TransparenciaDocumento::where('nome', self::ATA_DE_FUNDACAO)->firstOrFail();

        $this->assertSame('11/07/2025 · Registro nº 508', $ata->detalhe);
    }

    public function test_a_data_e_gravada_e_devolvida_como_data()
    {
        $secao = TransparenciaSecao::where('slug', self::SECAO_INSTITUCIONAL)->firstOrFail();
        $documento = TransparenciaDocumento::create([
            'secao_id' => $secao->id,
            'nome' => 'Ata de teste',
            'data_documento' => '2026-03-10',
        ]);

        $data = $documento->fresh()->data_documento;

        $this->assertInstanceOf(CarbonInterface::class, $data);
        $this->assertSame('10/03/2026', $data->format('d/m/Y'));
    }

    public function test_a_listagem_do_site_traz_a_data_sem_carregar_o_pdf()
    {
        $secao = TransparenciaSecao::comDocumentos()->firstWhere('slug', self::SECAO_INSTITUCIONAL);
        $ata = $secao->documentos->firstWhere('nome', self::ATA_DE_FUNDACAO);

        $this->assertSame('2025-07-11', $ata->data_documento->format(self::FORMATO_BANCO));
        $this->assertArrayNotHasKey('arquivo_data', $ata->getAttributes());
    }
}
