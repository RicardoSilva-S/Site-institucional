<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Support\BannerSlots;
use App\Support\SiteContent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/**
 * Banners do site (/adm/banners): carrossel do topo das páginas e imagens
 * ao lado das seções (ver App\Support\BannerSlots).
 *
 * As imagens são salvas dentro do banco (colunas image_data e image_mime).
 * No Render gratuito o disco do servidor é apagado a cada reinício, então
 * uma imagem salva em arquivo sumiria. O método image() entrega a imagem
 * para o site, pela rota pública /banners/{id}/imagem.
 *
 * Vindo do editor de uma página (/adm/paginas/{page}), o formulário manda
 * "voltar" com o id da página, e depois de salvar o painel volta para lá.
 */
class BannerController extends Controller
{
    protected const UPLOAD_DIR = 'uploads/banners';

    public function index(): View
    {
        return view('admin.banners.index', [
            'banners' => Banner::query()->select(Banner::LIST_COLUMNS)->orderBy('page')->orderBy('slot')->orderBy('sort_order')->orderBy('id')->get(),
        ]);
    }

    public function create(Request $request): View
    {
        $banner = new Banner(['active' => true, 'sort_order' => 0]);

        // Link "Trocar imagem" do editor da página já chega com a posição escolhida.
        $posicao = (string) $request->query('posicao', '');
        if ($this->isValidPosition($posicao)) {
            [$banner->page, $banner->slot] = BannerSlots::decode($posicao);
        }

        return $this->form($banner, $request);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request, true);
        $data = array_merge($data, $this->imageFields($request->file('image')));

        $banner = Banner::create($data);

        return $this->redirectBack($request, $banner, 'Banner adicionado.');
    }

    public function edit(Request $request, Banner $banner): View
    {
        return $this->form($banner, $request);
    }

    public function update(Request $request, Banner $banner): RedirectResponse
    {
        $data = $this->validated($request, false);

        if ($request->hasFile('image')) {
            $this->deleteImage($banner->image);
            $data = array_merge($data, $this->imageFields($request->file('image')));
        }

        $banner->update($data);

        return $this->redirectBack($request, $banner, 'Banner atualizado.');
    }

    public function destroy(Request $request, Banner $banner): RedirectResponse
    {
        $this->deleteImage($banner->image);
        $banner->delete();

        $message = $banner->slot
            ? 'Banner excluído. Sem outro banner ativo, a seção volta a mostrar a imagem padrão.'
            : 'Banner excluído.';

        return $this->redirectBack($request, $banner, $message);
    }

    protected function form(Banner $banner, Request $request): View
    {
        return view('admin.banners.form', [
            'banner' => $banner,
            'positions' => BannerSlots::options(),
            'voltar' => $this->returnPage($request),
        ]);
    }

    /**
     * Entrega a imagem guardada no banco (rota pública, usada pelo site).
     * O navegador guarda a imagem em cache; quando o banner é editado, o
     * endereço muda (parâmetro "v") e ele baixa a nova.
     */
    public function image(Banner $banner): Response
    {
        abort_unless($banner->image_data, 404);
 
        return response(base64_decode($banner->image_data), 200, [
            'Content-Type' => $banner->image_mime ?: 'image/jpeg',
            'Cache-Control' => 'public, max-age=31536000',
        ]);
    }

    protected function validated(Request $request, bool $imageRequired): array
    {
        $data = $request->validate([
            'posicao' => ['nullable', 'string', Rule::in($this->positionValues())],
            'image' => [$imageRequired ? 'required' : 'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'device' => ['nullable', Rule::in([Banner::DEVICE_DESKTOP, Banner::DEVICE_MOBILE])],
            'width' => ['nullable', 'integer', 'min:100', 'max:4000'],
            'height' => ['nullable', 'integer', 'min:100', 'max:4000'],
            'title' => ['nullable', 'string', 'max:255'],
            'display_title' => ['nullable', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:500'],
            'link' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ], [], [
            'posicao' => 'onde aparece',
            'image' => 'imagem',
            'device' => 'versão',
            'width' => 'largura',
            'height' => 'altura',
            'title' => 'nome interno',
            'display_title' => 'título no banner',
            'subtitle' => 'subtítulo',
            'sort_order' => 'ordem',
        ]);

        [$data['page'], $data['slot']] = BannerSlots::decode($data['posicao'] ?? null);
        unset($data['posicao'], $data['image']);

        if ($data['slot']) {
            // Imagem ao lado de uma seção: não tem versão desktop/mobile.
            $data['device'] = Banner::DEVICE_DESKTOP;
            $data['width'] = null;
            $data['height'] = null;
        } else {
            // Carrossel do topo: sem tamanho informado, usa o padrão da versão.
            $data['device'] = $data['device'] ?? Banner::DEVICE_DESKTOP;
            [$defaultWidth, $defaultHeight] = Banner::DEFAULT_SIZES[$data['device']];
            $data['width'] = $data['width'] ?? $defaultWidth;
            $data['height'] = $data['height'] ?? $defaultHeight;
        }

        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $data['active'] = $request->boolean('active');

        return $data;
    }

    /** Volta para o editor da página de onde o usuário veio, ou para a lista de banners. */
    protected function redirectBack(Request $request, Banner $banner, string $message): RedirectResponse
    {
        $page = $this->returnPage($request);

        if ($page === null) {
            return redirect()->route('admin.banners.index')->with('status', $message);
        }

        $anchor = $banner->slot ? '#secao-'.$banner->slot : '';

        return redirect()->to(route('admin.pages.show', $page).$anchor)->with('status', $message);
    }

    /** Id da página do painel em "voltar" (só se existir no config). */
    protected function returnPage(Request $request): ?string
    {
        $page = $request->input('voltar');

        return is_string($page) && SiteContent::page($page) !== null ? $page : null;
    }

    /** @return string[] valores aceitos no campo "posicao" */
    protected function positionValues(): array
    {
        return array_keys(Arr::collapse(BannerSlots::options()));
    }

    protected function isValidPosition(string $value): bool
    {
        return in_array($value, $this->positionValues(), true);
    }

    /** Campos da imagem para gravar no banco. */
    protected function imageFields(UploadedFile $file): array
    {
        return [
            'image' => Str::limit($file->getClientOriginalName(), 250, ''),
            'image_mime' => $file->getMimeType(),
            'image_data' => base64_encode(file_get_contents($file->getRealPath())),
        ];
    }

    protected function deleteImage(?string $path): void
    {
        if ($path && Str::startsWith($path, self::UPLOAD_DIR.'/')) {
            File::delete(public_path($path));
        }
    }
}
