<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewUser extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $password)
    {

        $this->name = $name;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from('suporte@itapesegdistribuidora.com.br')
            ->subject('Seu dados de acesso da Itapeseg')
            ->view('emails.new_user');
    }
}
