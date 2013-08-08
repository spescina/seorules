<?php

namespace Spescina\Seorules;

use Illuminate\Support\Facades\Config;

class Rule {

    private $substitutions = array();
    private $fields = array();

    public function __construct(Array $data = null) {
        if ($data) {
            foreach ($data as $field => $value) {
                $this->setField($field, $value);
            }
        }
    }

    public function setField($field, $value) {
        $this->fields[$field] = self::prepareValue($value);
    }

    public function addPlaceholder($placeholder, $content) {
        $this->substitutions[] = new Placeholder($placeholder, $content);
    }

    public function prepare() {
        $preparedRule = $this;
        
        foreach ($this->fields as $field => $value) {
            if (($field <> 'url') && ($field <> 'noindex')) {
                if (count($this->substitutions)) {
                    foreach ($this->substitutions as $placeholder) {
                        $search = self::buildPlaceholderString($placeholder->getPlaceholder(), Config::get('seorules::seorules.placeholder'));
                        
                        if (strpos($value, $search) !== false) {
                            $preparedRule->fields[$field] = self::replacePlaceholder($search, $placeholder->getContent(), $value);
                        }
                    }
                }
            }
        }
        
        return $preparedRule;
    }
    
    public function getPreparedField($field) {
        return $this->fields[$field];
    }

    private static function prepareValue($value) {
        $out = strip_tags($value);
        $out = trim($out);
        $out = str_replace('"', '', $out);

        return $out;
    }

    private static function buildPlaceholderString($placeholderLabel, $placeholderPattern) {
        return str_replace("placeholder", strtolower($placeholderLabel), $placeholderPattern);
    }

    private static function replacePlaceholder($search, $replace, $subject) {
        $value = str_replace($search, $replace, $subject);

        return self::prepareValue($value);
    }

}