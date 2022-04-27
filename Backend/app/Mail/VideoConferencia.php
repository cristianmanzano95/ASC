<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VideoConferencia extends Mailable
{
    use Queueable, SerializesModels;
    public $formulario;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($formulario)
    {
        $this->formulario = (array)$formulario;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Recurso asignado - CRIE')
                    ->view('emails.videoconferencia');
    }
}
