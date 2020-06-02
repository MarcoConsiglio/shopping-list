<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ShoppingList;

class Product extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    public function shopping_list()
    {
        return $this->belongsTo(ShoppingList::class);
    }
}
