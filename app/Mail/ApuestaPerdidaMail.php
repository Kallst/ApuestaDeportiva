<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use App\Models\Apuesta;

class ApuestaPerdidaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $apuesta;

    public function __construct(Apuesta $apuesta)
    {
        $this->apuesta = $apuesta;
    }

    public function build()
    {
        return $this->subject('Resultado de tu apuesta')
                    ->view('emails.apuesta_perdida');
    }
}