<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Textos que deixaram de ser editáveis pelo painel: nomes do menu, atalhos
 * das seções, títulos das colunas do rodapé, cabeçalhos de tabela e botões
 * presos a um link fixo (WhatsApp, e-mail). Eles agora ficam escritos direto
 * nas páginas. Apaga do banco para não aparecerem mais no painel.
 */
return new class extends Migration
{
    private const CHAVES = [
        'shared.nav.inicio',
        'shared.nav.institucional',
        'shared.nav.atuacao',
        'shared.nav.projetos',
        'shared.nav.editais',
        'shared.nav.transparencia',
        'shared.nav.contato',
        'shared.nav.cta',
        'shared.footer.col1.title',
        'shared.footer.col2.title',
        'shared.footer.col3.title',
        'institucional.nav.quemsomos',
        'institucional.nav.historia',
        'institucional.nav.governanca',
        'institucional.nav.marcolegal',
        'institucional.nav.documentos',
        'atuacao.nav.governanca',
        'atuacao.nav.observatorio',
        'atuacao.nav.pmo',
        'atuacao.nav.marcolegal',
        'atuacao.nav.capacitacao',
        'atuacao.nav.piloto',
        'home.compare.head.left',
        'home.compare.head.right',
        'marcolegal.mapa.col1',
        'marcolegal.mapa.col2',
        'marcolegal.mapa.col3',
        'editais.avisos.stat4',
        'editais.lista.title',
        'editais.lista.vazio',
        'contato.institucional.card1.title',
        'contato.institucional.card2.title',
        'contato.institucional.card3.title',
        'contato.form.btn_whatsapp',
        'contato.form.btn_email',
        'transparencia.cta.btn_whatsapp',
        'transparencia.cta.btn_email',
        'marcolegal.proc.cta1',
        'marcolegal.proc.cta2',
        'privacidade.contato.email',
        'privacidade.contato.whatsapp',
    ];

    public function up(): void
    {
        if (Schema::hasTable('site_texts')) {
            DB::table('site_texts')->whereIn('key', self::CHAVES)->delete();
        }
    }

    public function down(): void
    {
        // Nada a desfazer: os campos saíram do config/site_content.php.
    }
};