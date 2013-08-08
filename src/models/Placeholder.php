<?php

namespace Spescina\Seorules;

class Placeholder {
    
    private $placeholder;
    private $content;

    public function __construct($placeholder, $content) {
        $this->placeholder = $placeholder;
        $this->content = $content;
    }
    
    public function getPlaceholder() {
        return $this->placeholder;
    }
    
    public function getContent() {
        return $this->content;
    }
}