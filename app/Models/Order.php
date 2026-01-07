<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'name', 'email', 'note', 'total'];

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }
}
