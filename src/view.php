<?php

namespace Etmp;

use Etmp\Message;

class View {
    private $message;
    private $type;
    
    public function setMessage(Message $message)
    {
        $this->message = $message;
    }
    
    public function setType(integer $type): void
    {
        $this->type = $type;
    }
    
    public function __toString(): string
    {
        return $this->message;
    }
}