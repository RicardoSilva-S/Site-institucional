<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Data do documento (ex.: a data da ata) em transparencia_documentos.
 *
 * Até aqui a data só existia escrita dentro de "detalhe" (ex.:
 * "11/07/2025 · Registro nº 508"), e created_at/updated_at são a data do
 * cadastro, não a do documento. Esta coluna guarda a data de verdade e é
 * opcional, porque nem todo documento tem uma (CNPJ, documentos em
 * elaboração).
 *
 * Os documentos que já têm "dd/mm/aaaa" no começo do detalhe recebem a data
 * automaticamente. O texto de "detalhe" não é alterado, e o updated_at também
 * não, para a "Última atualização" da página continuar a mesma.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Deploy repetido ou banco que já tem a coluna: não faz nada.
        if (Schema::hasColumn('transparencia_documentos', 'data_documento')) {
            return;
        }

        Schema::table('transparencia_documentos', function (Blueprint $table) {
            $table->date('data_documento')->nullable()->after('detalhe');   // só o MySQL respeita o "after"
        });

        // Lê só id e detalhe: arquivo_data (o PDF em base64) fica de fora.
        $documentos = DB::table('transparencia_documentos')
            ->select('id', 'detalhe')
            ->whereNotNull('detalhe')
            ->get();

        foreach ($documentos as $documento) {
            // Só aceita a data no começo do texto, então "64.039.593/0001-82"
            // (CNPJ) e "Registrado no RTDPJ de Sarandi/PR" não viram data.
            if (! preg_match('#^(\d{2})/(\d{2})/(\d{4})(?!\d)#', $documento->detalhe, $partes)) {
                continue;
            }

            if (! checkdate((int) $partes[2], (int) $partes[1], (int) $partes[3])) {
                continue;
            }

            DB::table('transparencia_documentos')
                ->where('id', $documento->id)
                ->update(['data_documento' => $partes[3] . '-' . $partes[2] . '-' . $partes[1]]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('transparencia_documentos', 'data_documento')) {
            Schema::table('transparencia_documentos', function (Blueprint $table) {
                $table->dropColumn('data_documento');
            });
        }
    }
};
