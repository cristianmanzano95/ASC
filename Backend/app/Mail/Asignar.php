<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Asignar extends Mailable
{
    use Queueable, SerializesModels;
    public $formulario;
    public $horarios;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($horarios, $formulario)
    {
        $this->formulario = (array)$formulario;
        $this->horarios = $horarios;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Recurso asignado - CRIE')
                    ->view('emails.Asignar');
    }
}
