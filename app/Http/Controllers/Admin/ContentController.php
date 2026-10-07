<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteText;
use App\Support\SiteContent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

/**
 * Textos do site, uma página por vez (/adm/paginas/{page}).
 *
 * - show:    lista os textos da página, agrupados por seção
 * - update:  salva as alterações de todos os textos da página
 * - store:   insere um texto novo numa seção
 * - destroy: exclui um texto (inserido = apaga; original = esvazia)
 * - restore: volta um texto original ao conteúdo de config/site_content.php
 */
class ContentController extends Controller
{
    /** Seções em que não faz sentido inserir textos soltos. */
    protected const NO_EXTRAS = ['shared.nav', 'atuacao.nav'];

    public function show(string $page): View
    {
        $schema = $this->pageOr404($page);

        // Garante que campos novos do config já estejam no banco.
        SiteContent::sync();

        $texts = SiteText::query()
            ->where('page', $page)
            ->orderBy('sort_order')
            ->get()
            ->groupBy('group');

        // Monta as seções na ordem do config (mesmo as que estiverem vazias).
        $groups = collect($schema['groups'])->map(fn ($group) => [
            'id' => $group['id'],
            'label' => $group['label'],
            'texts' => $texts->get($group['id'], collect()),
            'canAdd' => ! in_array("{$page}.{$group['id']}", self::NO_EXTRAS, true),
        ]);

        return view('admin.pagina', [
            'page' => $schema,
            'groups' => $groups,
            'defaults' => SiteContent::defaults(),
        ]);
    }

    public function update(Request $request, string $page): RedirectResponse
    {
        $this->pageOr404($page);

        // O formulário manda texts[id]=valor.
        $validated = $request->validate([
            'texts' => ['required', 'array'],
            'texts.*' => ['nullable', 'string', 'max:20000'],
        ]);

        $texts = SiteText::query()
            ->where('page', $page)
            ->whereIn('id', array_keys($validated['texts']))
            ->get();

        foreach ($texts as $text) {
            $text->update(['value' => $validated['texts'][$text->id] ?? '']);
        }

        SiteContent::forget();

        return back()->with('status', 'Alterações salvas. O site já está mostrando os novos textos.');
    }

    public function store(Request $request, string $page): RedirectResponse
    {
        $schema = $this->pageOr404($page);
        $groupIds = collect($schema['groups'])->pluck('id')->all();

        $validated = $request->validate([
            'group' => ['required', 'string', 'in:'.implode(',', $groupIds)],
            'label' => ['required', 'string', 'max:120'],
            'value' => ['required', 'string', 'max:20000'],
        ], [], [
            'label' => 'nome do texto',
            'value' => 'texto',
        ]);

        abort_if(in_array("{$page}.{$validated['group']}", self::NO_EXTRAS, true), 422);

        $group = collect($schema['groups'])->firstWhere('id', $validated['group']);

        SiteText::create([
            'page' => $page,
            'group' => $group['id'],
            'group_label' => $group['label'],
            'key' => "{$page}.{$group['id']}.extra-".Str::lower(Str::random(8)),
            'label' => $validated['label'],
            'value' => $validated['value'],
            'long' => true,
            'custom' => true,
            'sort_order' => (int) SiteText::query()->where('page', $page)->max('sort_order') + 10,
        ]);

        SiteContent::forget();

        return back()->with('status', 'Texto adicionado. Ele aparece no fim da seção "'.$group['label'].'".');
    }

    public function destroy(SiteText $text): RedirectResponse
    {
        if ($text->custom) {
            $text->delete();
            $message = 'Texto excluído.';
        } else {
            // Textos originais estão "presos" a um lugar do layout. Em vez de
            // apagar a linha, esvaziamos o valor: o elemento some do site e
            // pode ser restaurado depois.
            $text->update(['value' => '']);
            $message = 'Texto excluído do site. Use "Restaurar original" se quiser trazê-lo de volta.';
        }

        SiteContent::forget();

        return redirect()
            ->route('admin.pages.show', $text->page)
            ->with('status', $message);
    }

    public function restore(SiteText $text): RedirectResponse
    {
        abort_if($text->custom, 404);

        $text->update(['value' => SiteContent::defaults()[$text->key] ?? '']);
        SiteContent::forget();

        return redirect()
            ->route('admin.pages.show', $text->page)
            ->with('status', 'Texto restaurado para o original.');
    }

    protected function pageOr404(string $page): array
    {
        $schema = SiteContent::page($page);
        abort_if($schema === null, 404);

        return $schema;
    }
}