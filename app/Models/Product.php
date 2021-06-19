<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ShoppingList;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Represents a Product in a ShoppingList.
 *
 * @property        int                         $id
 * @property        string                      $name
 * @property        string                      $brand
 * @property        float                       $price
 * @property        float                       $quantity
 * @property        float                       $cart_quantity
 * @property        string                      $measure
 * @property        string                      $note
 * @property        int                         $shopping_list_id
 * @property-read   \App\Models\ShoppingList    $shoppingList
 */
class Product extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var int Refers to a retail Product.
     */
    public const RETAIL = 0;

    /**
     * @var int Refers to a wholesale Product.
     */
    public const WHOLESALE = 1;

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
    public function shoppingList()
    {
        return $this->belongsTo(ShoppingList::class);
    }

    /**
     * Check if this is a retail or wholesale Product.
     *
     * @return boolean
     */
    public function type() {
        if($this->measure == null)
            return self::RETAIL;
        else
            return self::WHOLESALE;
    }

    /**
     * Check if this Product is in the cart.
     *
     * @return boolean
     */
    public function inTheCart()
    {
        return $this->cart_quantity > 0 ? true : false;
    }
}
