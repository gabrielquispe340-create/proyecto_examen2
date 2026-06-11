<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CredencialMail extends Mailable
{
    use Queueable, SerializesModels;

    public $codigo_registro;
    public $contrasena_correo;

    /**
     * Create a new message instance.
     */
    public function __construct($codigo_registro, $contrasena_correo)
    {
        $this->codigo_registro = $codigo_registro;
        $this->contrasena_correo = $contrasena_correo;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Tus Credenciales de Acceso - CUP FICCT',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.credencial',
            with: [
                'codigo_registro' => $this->codigo_registro,
                'contrasena_correo' => $this->contrasena_correo,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
