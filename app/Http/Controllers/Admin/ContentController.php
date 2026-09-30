<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\SiteContent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Painel /admin/conteudo — protegido por auth (ver routes/web.php).
 *
 * Lê a estrutura de campos em App\Support\SiteContent::schema() (que vem de
 * config/site_content.php) para montar o formulário, e grava as edições na
 * tabela site_content_values através de SiteContent::save().
 */
class ContentController extends Controller
{
    public function edit(): View
    {
        $schema = SiteContent::schema();
        $defaults = SiteContent::defaults();

        // Valor atual de cada campo (para preencher o formulário), já
        // considerando o que foi digitado numa tentativa anterior que
        // falhou na validação (old('fields.<key>')).
        $currentValues = [];
        foreach ($defaults as $key => $default) {
            $currentValues[$key] = old("fields.{$key}", SiteContent::text($key));
        }

        return view('admin.content-edit', [
            'schema' => $schema,
            'currentValues' => $currentValues,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        // O formulário manda os campos como fields[home.hero.title]=...
        // (array), não como "home.hero.title" puro — o PHP troca pontos
        // por underscore em nomes de campo fora de colchetes, o que
        // quebraria essas keys. Ver resources/views/admin/content-edit.blade.php.
        $validated = $request->validate([
            'fields' => ['required', 'array'],
            'fields.*' => ['nullable', 'string', 'max:20000'],
        ]);

        SiteContent::save($validated['fields']);

        return redirect()
            ->route('admin.content.edit')
            ->with('status', 'Alterações salvas. O site já está mostrando os novos textos.');
    }

    public function reset(): RedirectResponse
    {
        SiteContent::resetAll();

        return redirect()
            ->route('admin.content.edit')
            ->with('status', 'Textos restaurados para o padrão original.');
    }

    public function export(): JsonResponse
    {
        $values = [];
        foreach (SiteContent::defaults() as $key => $default) {
            $values[$key] = SiteContent::text($key);
        }

        return response()->json($values, 200, [
            'Content-Disposition' => 'attachment; filename="idtnpr-textos.json"',
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}
