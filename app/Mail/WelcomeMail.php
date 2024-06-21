<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $login;
    public $password;

    /**
     * Create a new message instance.
     */
    public function __construct($login, $passwort)
    {
        $this->login = $login;
        $this->password = $passwort;
    }


    public function build()
    {
        return $this->subject('Welcome to our application')
            ->view('emails.welcome')
            ->with([
                'login' => $this->login,
                'password' => $this->password,
            ]);
    }
}
