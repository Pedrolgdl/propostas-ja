<?php

namespace App\Mail;

use App\Models\Property;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PropertyUpdateSolicitation extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $changes;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $changes)
    {
        $this->user = $user;
        $this->changes = $changes;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.property.update');
    }
}
