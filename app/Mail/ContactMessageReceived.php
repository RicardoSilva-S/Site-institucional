<?php

namespace App\Mail;

use App\Models\ContactMessage;
use Illuminate\Mail\Mailable;

class ContactMessageReceived extends Mailable
{
    /** @var ContactMessage */
    public $contact;

    public function __construct(ContactMessage $contact)
    {
        $this->contact = $contact;

        if ($contact->email) {
            $this->replyTo($contact->email, $contact->nome);
        }
    }

    public function build(): self
    {
        return $this
            ->subject('Nova mensagem pelo site — '.$this->contact->nome)
            ->text('emails.contact-message');
    }
}
