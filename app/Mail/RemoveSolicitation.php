<?php

namespace App\Mail;

use App\Models\Property;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RemoveSolicitation extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $property;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Property $property)
    {
        $this->user = $user;
        $this->property = $property;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.property.admin.remove');
    }
}
