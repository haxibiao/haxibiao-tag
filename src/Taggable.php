<?php

namespace Haxibiao\Tag;

use App\Model;

class Taggable extends Model
{

    protected $table = 'taggables';
    public $guarded  = [];

    public function taggable()
    {
        return $this->morphTo();
    }
}
