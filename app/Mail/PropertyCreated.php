<?php

namespace App\Mail;

use App\Models\Property;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PropertyCreated extends Mailable
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
        $view =  $this->isAdmin ? 'email.property.admin.created' : 'email.property.created';
        $subject = $this->isAdmin ? 'Um novo imóvel foi cadastrado e precisa ser verificado.' : 'Seu imóvel foi cadastrado com sucesso!';
        return $this->view($view)->subject($subject);
    }
}
