<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $token;
    public $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->url = 'http://localhost:8000';
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if (env('APP_ENV') != 'local')
            $this->url = 'https://mecanise.com.br';

        return $this
            ->subject('Recuperação de senha')
            ->from('contato@mecanise.com.br')
            ->view('emails.forgot_password');
    }
}
