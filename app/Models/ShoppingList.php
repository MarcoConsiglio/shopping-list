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
}
