<?php

namespace Spescina\Seorules;

class Rule extends Clean {

    public function __construct(Array $data) {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }

}