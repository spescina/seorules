<?php

namespace Spescina\Seorules;

class Clean {

    private $data = array();

    public function __get($property) {
        if (array_key_exists($property, $this->data)) {
            return $this->data[$property];
        } else {
            return null;
        }
    }

    public function __set($property, $value) {
        $this->data[$property] = $value;
    }

}