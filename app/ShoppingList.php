<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\{Product, User};

class ShoppingList extends Model
{
    public $guarded = [];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class);
    }
}
