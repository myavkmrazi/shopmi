<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $fillable = ['product_id', 'title', 'price', 'quantity', 'image', 'slug'];
}
