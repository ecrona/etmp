<?php

namespace Etmp;

class View {
    private $message, $type;
    
    public function setMessage(string $message)
    {
        $this->message = $message;
    }
    
    public function setType(int $type): void
    {
        $this->type = $type;
    }
    
    public function __toString(): string
    {
        return $this->message;
    }
}