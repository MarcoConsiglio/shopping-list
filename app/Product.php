<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ShoppingList;

/**
 * Represents a Product in a ShoppingList.
 */
class Product extends Model
{
    /**
     * Attributes protected from mass assignment.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * A Product belongs to a ShoppingList.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function shopping_list()
    {
        return $this->belongsTo(ShoppingList::class);
    }
}
