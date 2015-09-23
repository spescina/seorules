<?php

namespace Spescina\Seorules;

class Seo {

    private static $instance = false;
    private $rules;
    private $definedRule;
    private $preparedRule;
    private $route;
    private $url;
    private $prepared = false;

    static function getInstance() {
        if (self::$instance === false) {
            self::$instance = new Seo;
        }

        return self::$instance;
    }

    public function init() {
        $this->definedRule = new Rule(config('seorules.rule'));
        
        $this->loadRules();
        $this->loadCurrentRoute();
        $this->loadCurrentUrl();
        
        $this->defineRule();
    }

    private function loadRules() {
        $modelClass = Config::get('seorules::seorules.model');
        $this->rules = $modelClass::orderBy('priority', 'desc')->get();
    }

    private function loadCurrentRoute() {
        $this->route = \Route::currentRouteName();
    }

    private function loadCurrentUrl() {
        $this->url = \Request::fullUrl();
    }

    private function defineRule() {
        foreach ($this->rules as $rule) {
            if ($rule->route == $this->route) {
                if (!empty($rule->pattern)) {
                    if (!preg_match("|{$rule->pattern}|", $this->url)) {
                        continue;
                    }
                }

                $this->definedRule = new Rule(array(
                    'title' => $rule->title,
                    'description' => $rule->description,
                    'keywords' => $rule->keywords,
                    'noindex' => $rule->noindex
                ));

                return;
            }
        }
    }

    public function addPlaceholder($placeholder, $content) {
        $this->definedRule->addPlaceholder($placeholder,$content);
    }

    public function prepareRule() {
        $this->preparedRule = $this->definedRule->prepare();
        
        $this->prepared = true;
    }
    
    public function get($field) {
        if (!$this->prepared) {
            $this->prepareRule();
        }
        
        return $this->preparedRule->getPreparedField($field);
    }
}
