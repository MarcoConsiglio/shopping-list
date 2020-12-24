<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ShoppingList;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Represents a Product in a ShoppingList.
 */
class Product extends Model
{
    use HasFactory;

    /**
     * Attributes protected from mass assignment.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        "price" => "float",
        "quantity" => "float",
        "cart_quantity" => "float"
    ];

    /**
     * A Product belongs to a ShoppingList.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function shoppingLists()
    {
        return $this->belongsTo(ShoppingList::class);
    }
}
