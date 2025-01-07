<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Log;

class ConfermaAssociazione extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(private $dati)
    {
        $this->dati = $dati;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Conferma Associazione',
            from: env('MAIL_FROM_ADDRESS'),
            // cc: env('MAIL_CC_ADDRESS'), chiedere se d'è da inserire email ufficiale human o altro
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.confermaAssociazione',
            with:[
                'nome' => $this->dati->nome,
                'cognome' => $this->dati->cognome,
                'nomeGenitore' => $this->dati->nome_genitore,
                'cognomeGenitore' => $this->dati->cognome_genitore,
                'numeroTessera' => str_pad($this->dati->n_tessera, 5, '0', STR_PAD_LEFT),
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
