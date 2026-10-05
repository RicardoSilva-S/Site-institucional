<?php

namespace App\Http\Controllers;

use App\Mail\ContactMessageReceived;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Throwable;

class ContactController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nome' => ['required', 'string', 'max:150'],
            'cargo' => ['nullable', 'string', 'max:150'],
            'orgao' => ['required', 'string', 'max:200'],
            'email' => ['nullable', 'email', 'max:190'],
            'telefone' => ['nullable', 'string', 'max:30'],
            'area' => ['nullable', 'string', Rule::in(ContactMessage::AREAS)],
            'mensagem' => ['required', 'string', 'max:5000'],
        ]);

        // Campo-isca ("honeypot"): invisível para pessoas, preenchido por robôs.
        // Responde como se tivesse dado certo, mas não grava nada.
        if (filled($request->input('website'))) {
            return $this->sucesso();
        }

        $contact = ContactMessage::create($data);

        // A mensagem já está salva; se o e-mail falhar, não perdemos o contato.
        try {
            Mail::to(config('mail.contact_to'))->send(new ContactMessageReceived($contact));
        } catch (Throwable $e) {
            report($e);
        }

        return $this->sucesso();
    }

    private function sucesso(): RedirectResponse
    {
        return redirect()
            ->to(route('contato').'#diagnostico')
            ->with('contact_status', 'Mensagem enviada! Nossa equipe vai responder em breve.');
    }
}
