<?php   namespace Spescina\Seorules;

use Illuminate\Database\Eloquent\Model;

class Seorule extends Model {
    
    public $timestamps = false;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = config('seorules.table');
    }

}
