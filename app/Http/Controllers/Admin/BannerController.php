<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Support\SiteContent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\View\View;

/**
 * Banners do topo do site (/adm/banners).
 *
 * As imagens são salvas dentro do banco (colunas image_data e image_mime).
 * No Render gratuito o disco do servidor é apagado a cada reinício, então
 * uma imagem salva em arquivo sumiria. O método image() entrega a imagem
 * para o site, pela rota pública /banners/{id}/imagem.
 */
class BannerController extends Controller
{
    protected const UPLOAD_DIR = 'uploads/banners';

    public function index(): View
    {
        return view('admin.banners.index', [
            'banners' => Banner::query()->select(Banner::LIST_COLUMNS)->orderBy('page')->orderBy('sort_order')->orderBy('id')->get(),
            'pages' => $this->pageOptions(),
        ]);
    }

    public function create(): View
    {
        return view('admin.banners.form', [
            'banner' => new Banner(['active' => true, 'sort_order' => 0]),
            'pages' => $this->pageOptions(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request, true);
        $data = array_merge($data, $this->imageFields($request->file('image')));

        Banner::create($data);

        return redirect()->route('admin.banners.index')->with('status', 'Banner adicionado.');
    }

    public function edit(Banner $banner): View
    {
        return view('admin.banners.form', [
            'banner' => $banner,
            'pages' => $this->pageOptions(),
        ]);
    }

    public function update(Request $request, Banner $banner): RedirectResponse
    {
        $data = $this->validated($request, false);

        if ($request->hasFile('image')) {
            $this->deleteImage($banner->image);
            $data = array_merge($data, $this->imageFields($request->file('image')));
        }

        $banner->update($data);

        return redirect()->route('admin.banners.index')->with('status', 'Banner atualizado.');
    }

    public function destroy(Banner $banner): RedirectResponse
    {
        $this->deleteImage($banner->image);
        $banner->delete();

        return redirect()->route('admin.banners.index')->with('status', 'Banner excluído.');
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
            'page' => ['nullable', 'string', 'in:'.implode(',', array_keys($this->pageOptions()))],
            'image' => [$imageRequired ? 'required' : 'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'title' => ['nullable', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:500'],
            'link' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ], [], [
            'image' => 'imagem',
            'title' => 'título',
            'subtitle' => 'subtítulo',
            'sort_order' => 'ordem',
        ]);

        unset($data['image']);
        $data['page'] = $data['page'] ?: null;
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $data['active'] = $request->boolean('active');

        return $data;
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

    /** @return array<string, string> [nome da rota => nome da página] */
    protected function pageOptions(): array
    {
        $options = [];
        foreach (SiteContent::schema() as $page) {
            if (! empty($page['route'])) {
                $options[$page['route']] = $page['pageLabel'];
            }
        }

        return $options;
    }
}