<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;

class ShoppingList extends Model
{
    public $guarded = [];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
