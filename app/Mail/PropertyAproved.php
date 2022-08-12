<?php

namespace App\Mail;

use App\Models\Property;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PropertyAproved extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $property;
    private $isAdmin;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Property $property, $isAdmin)
    {
        $this->user = $user;
        $this->property = $property;
        $this->isAdmin = $isAdmin;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $view =  $this->isAdmin ? 'email.property.approved' : 'email.property.admin.approved';
        return $this->view($view);
    }
}
