<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class NotificacionSLA extends Mailable
{
    use Queueable, SerializesModels;
    public $details;

    /**
     * Create a new message instance.
     * @param $details
     * @return void
     */

    public function __construct($details)
    {
        $this->details = $details;
    }

    public function build()
    {
        return $this->from('soporte@gruporadical.com')
                    ->subject($this->details['code'].'>Notificación de cierre de un ticket')
                    ->priority(1)
                    ->view('emails.notificacionSLA');
    }
}

