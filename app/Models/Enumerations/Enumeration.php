<?php

namespace App\Models\Enumerations;

/**
 * Defines an abstract Enumeration.
 */
abstract class Enumeration
{
    /**
     * Where the constants resides.
     *
     * @var array $constCacheArray
     */
    private static $constCacheArray = NULL;

    /**
     * Get the list of al constants of the Enumeration.
     *
     * @return array
     */
    private static function getConstants()
    {
        if (self::$constCacheArray == NULL) {
            self::$constCacheArray = [];
        }
        $calledClass = get_called_class();
        if (!array_key_exists($calledClass, self::$constCacheArray)) {
            $reflect = new \ReflectionClass($calledClass);
            self::$constCacheArray[$calledClass] = $reflect->getConstants();
        }
        return self::$constCacheArray[$calledClass];
    }

    /**
     * Check if  $name is a constant of this Enumeration.
     * nell'enumerazione.
     *
     * @param string $name The name of the constant whose existence you want to check.
     * @param boolean $stricts Set it true if you want case sensitive search.
     * @return boolean
     */
    public static function isValidName(string $name, bool $strict = false)
    {
        $constants = self::getConstants();

        if ($strict) {
            return array_key_exists($name, $constants);
        }

        $keys = array_map('strtolower', array_keys($constants));
        return in_array(strtolower($name), $keys);
    }

    /**
     * Check if $value is a valid constant.
     *
     * @param int $value The value whose existence you want to check.
     * @param boolean $strict Use it in order to check the $value type is also correct.
     * @return boolean
     */
    public static function isValidValue($value, bool $strict = true)
    {
        $values = array_values(self::getConstants());
        return in_array($value, $values, $strict);
    }

    /**
     * Gets the first name of the constant starting from its value.
     * More than one constant with the same value will make trouble.
     *
     * @param integer $value The value of the constant whose name you want to know
     * @param boolean $strict Use it in order to check the $value type is also correct.
     * @return string|void
     */
    public static function getConstantName($value, bool $strict = false)
    {
        if (self::isValidValue($value)) {
            return array_search($value, self::getConstants(), $strict);
        } else return;
    }
}
