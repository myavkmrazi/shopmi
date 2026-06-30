<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Filter extends Model
{
    protected $table = 'filters';

    protected $fillable = ['title', 'filter_group_id'];

    public $timestamps = false;

    public function group(): HasOne
    {
        return $this->hasOne(FilterGroup::class, 'id', 'filter_group_id');
    }
}
