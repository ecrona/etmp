<?php

namespace Etmp;

class Message {
    private $sections;
    private $selectedSection;
    
    public function __construct()
    {
        $this->sections = [];
    }
    
    public function section(string $header = ''): Message
    {
        $this->selectedSection = sizeof($this->sections);

        $this->sections[] = [
            'header' => $header
        ];
        
        return $this;
    }
    
    public function description($description): Message
    {
        $this->sections[$this->selectedSection]['description'] = $description;
        
        return $this;
    }
    
    public function __toString(): string
    {
        $text = '';
        
        foreach ($this->sections as $section) {
            $text .= "\n\n" . $section['header'];
            
            if (isset($section['description'])) {
                if (is_string($section['description'])) {
                    $text .= "\n\t" . $section['description'];
                } else if (is_array($section['description'])) {
                    foreach ($section['description'] as $row) {
                        if (is_string($row)) {
                            $text .= "\n\t" . $row;
                        } else if (is_array($row)) {
                            $text .= "\n\t" . implode("\t", $row);
                        }
                    }
                }
            }
        }
        
        return $text . "\n";
    }
}