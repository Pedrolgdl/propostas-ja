<?php

namespace App\Mail;

use App\Models\Property;
use App\Models\User;
use App\Models\VisitScheduling;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VisitAccepted extends Mailable
{
    use Queueable, SerializesModels;

    public $visit;
    public $user;
    public $property;
    private $isAdmin;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(VisitScheduling $visit, User $user, Property $property, $isAdmin)
    {
        $this->visit = $visit;
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
        $view =  $this->isAdmin ? 'email.visit.accepted' : 'email.visit.admin.accepted';
        return $this->view($view);
    }
}
