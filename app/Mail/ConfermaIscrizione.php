<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ConfermaIscrizione extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(private $datiIscrizione)
    {
        $this->datiIscrizione = $datiIscrizione;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Conferma iscrizione al corso: '. $this->datiIscrizione->titolo,
            from: env('MAIL_FROM_ADDRESS'),
            //eventuale cc
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.confermaIscrizione',
            with:[
                'nome'=> $this->datiIscrizione->nome,
                'cognome'=> $this->datiIscrizione->cognome,
                'email'=> $this->datiIscrizione->email,
                'corso'=> $this->datiIscrizione->titolo,
                'descrizione'=> $this->datiIscrizione->descrizione,
                'data_inizio'=> $this->datiIscrizione->data_inizio,
                'data_fine'=> $this->datiIscrizione->data_fine,
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
