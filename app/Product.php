<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ShoppingList;

/**
 * Un Prodotto di una Lista della Spesa.
 */
class Product extends Model
{
    protected $guarded = [];

    /**
     * Un Prodotto appartiene ad una sola lista della spesa.
     */
    public function shopping_list()
    {
        return $this->belongsTo(ShoppingList::class);
    }
}
