<?php

namespace App\Api;


// Essa classe retorna mensagens de erro que podem ser personalizadas
Class ApiMessages
{
    private $message = [];

    public function __construct(string $message, array $data = [])
    {
        $this->message['message'] = $message;
        $this->message['errors']  = $data;
    }

    public function getMessage()
    {
        return $this->message;
    }
}