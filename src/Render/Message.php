<?php

namespace Etmp\Render;

use Etmp\Render\Color;

class Message {
    private $sections;
    private $selectedSection;
    
    public function __construct()
    {
        $this->sections = [];
    }
    
    public function section(string $header = null, int $color = Color::Default): Message
    {
        $this->selectedSection = sizeof($this->sections);

        $this->sections[] = [
            'header' => $header,
            'headerColor' => $color,
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
            $text .= "\n" . Colorize::format($section['header'], $section['headerColor']);
            
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

            $text .= "\n";
        }
        
        return $text . "\n";
    }
}