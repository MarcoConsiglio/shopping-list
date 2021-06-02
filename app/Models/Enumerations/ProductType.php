<?php
namespace App\Models\Enumerations;

/**
 * Represents the Product sale method.
 */
abstract class ProductType extends Enumeration
{
    /**
     * @var int References a retail Product.
     */
    public const RETAIL = 0;

    /**
     * @var int References a wholesale Product.
     */
    public const WHOLESALE = 0;
}

