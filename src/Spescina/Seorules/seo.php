<?php

namespace Spescina\Seorules;

use Illuminate\Support\Facades\Config;

class Seo {

    private static $instance = false;
    private $rules;
    private $definedRule;
    private $preparedRule;
    private $route;
    private $url;

    static function getInstance() {
        if (self::$instance === false) {
            self::$instance = new Seo;
        }

        return self::$instance;
    }

    public function init() {
        $this->definedRule = new Rule(Config::get('seorules::seorules.rule'));
        
        $this->loadRules();
        $this->loadCurrentRoute();
        $this->loadCurrentUrl();
        
        $this->defineRule();
    }

    private function loadRules() {
        $this->rules = Seorule::orderBy('priority', 'asc')->get();
    }

    private function loadCurrentRoute() {
        $this->route = \Route::currentRouteName();
    }

    private function loadCurrentUrl() {
        $this->url = \Request::url();
    }

    private function defineRule() {
        foreach ($this->rules as $rule) {
            if (preg_match('^' . $rule->route . '^', $this->route) > 0) {
                if (!empty($rule->pattern)) {
                    $pattern = '^' . str_replace('/', '\/', $rule->pattern) . '^';

                    if (!preg_match($pattern, $this->url) > 0) {
                        continue;
                    }
                }

                $this->rule = new Rule(array(
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
    }
    
    public function getPreparedField($field) {
        return $this->preparedRule->getPreparedField($field);
    }
}