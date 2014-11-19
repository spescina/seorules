<?php   namespace Spescina\Seorules;

use Illuminate\Support\Facades\Config;

class Seorule extends \Eloquent {
    
    public $timestamps = false;

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->table = Config::get('seorules::database.table');
    }

}
