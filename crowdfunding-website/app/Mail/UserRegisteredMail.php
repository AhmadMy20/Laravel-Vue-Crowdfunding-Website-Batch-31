<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserRegisteredMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $user, $emailMessage;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $emailMessage)
    {
        $this->user = $user;
        $this->emailMessage = $emailMessage;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('send_email')
                    ->with([
                        'user' => $this->user,
                        'emailMessage' => $this->emailMessage
                    ]);
    }
}
