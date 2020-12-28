<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\{Product, User};
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShoppingList extends Model
{
    use HasFactory;

    /**
     * Attributes protected from mass assignment.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * A ShoppingList can have zero or more Products.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * A ShoppingList belongs to an autor (User).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Return the sum of the prices according to cart quantity first (if specified),
     * then to quantity,
     *
     * @return void
     */
    public function total_price() {
        $sum = 0;
        foreach ($this->products as $product) {
            if($product->cart_quantity > 0)
                $sum += $product->cart_quantity * $product->price;
            else
                $sum += $product->quantity * $product->price;
        }
        return $sum;
    }
}
