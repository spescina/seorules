<?php

namespace Spescina\Seorules;

use Illuminate\Support\Facades\Config;

class Seo {
    
    private static $instance = false;
    
    private $placeholderPattern;
    private $defaultContent;
    
    public $rule;
    public $data;

    static function getInstance() {
        if (self::$instance === false) {
            self::$instance = new Seo;
        }

        return self::$instance;
    }
    
    public function start(){
        $config = Config::get('seorules::seorules');
        
        $this->placeholderPattern = $config['placeholderPattern'];
        $this->defaultContent = new Rule(array(
            'title' => $config['defaultContent']['title'],
            'description' => $config['defaultContent']['description'],
            'keywords' => $config['defaultContent']['keywords'],
            'noindex' => $config['defaultContent']['noindex']
        ));
    }
}
