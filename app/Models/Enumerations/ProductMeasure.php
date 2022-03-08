<?php
namespace App\Models\Enumerations;

/**
 * Represents the Product measure.
 */
abstract class ProductMeasure extends Enumeration
{
    /**
     * @var int The milliliters measure.
     */
    public const MILLILITERS    = "ml";

    /**
     * @var int The liters measure.
     */
    public const LITERS         = "l";

    /**
     * @var int The grams measure.
     */
    public const GRAMS          = "g";

    /**
     * @var int The hectogram measure.
     */
    public const HECTOGRAMS     = "hg";

    /**
     * @var int The kilos measure.
     */
    public const KILOS          = "kg";

}
