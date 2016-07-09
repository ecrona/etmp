<?php

namespace Etmp\Render;

use Etmp\Render\Color;

class Message {
    private $sections;
    private $selectedSection;
    
    /**
     * Constructs the class instance and sets up the sections base.
     */
    public function __construct()
    {
        $this->sections = [];
    }
    
    /**
     * Creates a section with a selected header text and color.
     *
     * @param  string $header
     * @param  int    $color  (optional)
     * @return Etmp\Render\Message
     */
    public function section(string $header = null, int $color = Color::Default): Message
    {
        $this->selectedSection = sizeof($this->sections);

        $this->sections[] = [
            'header' => $header,
            'headerColor' => $color,
        ];
        
        return $this;
    }
    
    /**
     * Adds a description to a previously created section.
     *
     * @param  string $description
     * @return Etmp\Render\Message
     */
    public function description($description): Message
    {
        $this->sections[$this->selectedSection]['description'] = $description;
        
        return $this;
    }
    
    /**
     * Renders out the message with sections and descriptions,
     * proper sectioning, margin and spaces, including color
     * formatting when this instance is called as a string.
     *
     * @return string
     */
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