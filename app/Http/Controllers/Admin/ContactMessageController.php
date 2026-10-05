<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Painel /admin/mensagens — lista as mensagens enviadas pelo formulário de
 * contato do site (protegido por auth, ver routes/web.php).
 */
class ContactMessageController extends Controller
{
    public function index(): View
    {
        return view('admin.messages', [
            'messages' => ContactMessage::orderByDesc('created_at')->simplePaginate(20),
            'unread' => ContactMessage::whereNull('read_at')->count(),
        ]);
    }

    public function toggleRead(ContactMessage $message): RedirectResponse
    {
        $message->read_at = $message->isRead() ? null : now();
        $message->save();

        return back();
    }
}
