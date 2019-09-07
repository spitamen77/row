<?php

namespace app\components;

use BadMethodCallException;
use ReflectionClass;
use UnexpectedValueException;
use Uni;
use uni\helpers\ArrayHelper;

/**
 * Class BaseEnum
 *
 * @package uni2mod\enum\helpers
 */
abstract class BaseEnum
{
    /**
     * @var string message category
     */
    public static $messageCategory = 'app';

    /**
     * The cached list of constants by name.
     *
     * @var array
     */
    private static $byName = [];

    /**
     * The cached list of constants by value.
     *
     * @var array
     */
    private static $byValue = [];

    /**
     * @var array list of properties
     */
    private static $list;

    /**
     * The value managed by this type instance.
     *
     * @var mixed
     */
    private $_value;

    /**
     * Sets the value that will be managed by this type instance.
     *
     * @param mixed $value The value to be managed
     *
     * @throws UnexpectedValueException If the value is not valid
     */
    public function __construct($value)
    {
        if (!self::isValidValue($value)) {
            throw new UnexpectedValueException("Value '{$value}' is not part of the enum " . get_called_class());
        }

        $this->_value = $value;
    }

    /**
     * Creates a new type instance using the name of a value.
     *
     * @param string $name The name of a value
     *
     * @throws UnexpectedValueException
     *
     * @return $this The new type instance
     */
    public static function createByName($name)
    {
        $constants = self::getConstantsByName();

        if (!array_key_exists($name, $constants)) {
            throw new UnexpectedValueException("Name '{$name}' is not exists in the enum constants list " . get_called_class());
        }

        return new static($constants[$name]);
    }

    /**
     * get constant key by value(label)
     *
     * @param $value
     *
     * @return mixed
     */
    public static function getValueByName($value)
    {
        $list = self::listData();

        return array_search($value, $list);
    }

    /**
     * Creates a new type instance using the value.
     *
     * @param mixed $value The value
     *
     * @throws UnexpectedValueException
     *
     * @return $this The new type instance
     */
    public static function createByValue($value)
    {
        $constants = self::getConstantsByValue();

        if (!array_key_exists($value, $constants)) {
            throw new UnexpectedValueException("Value '{$value}' is not exists in the enum constants list " . get_called_class());
        }

        return new static($value);
    }

    /**
     * Get list data
     *
     * @static
     *
     * @return mixed
     */
    public static function listData()
    {
        $class = get_called_class();

        if (!isset(self::$list[$class])) {
            $reflection = new ReflectionClass($class);
            self::$list[$class] = $reflection->getStaticPropertyValue('list');
        }

        $result = ArrayHelper::getColumn(self::$list[$class], function ($value) {
            return Uni::t(self::$messageCategory, $value);
        });

        return $result;
    }

    /**
     * Get label by value
     *
     * @var string value
     *
     * @return string label
     */
    public static function getLabel($value)
    {
        $list = static::$list;

        if (isset($list[$value])) {
            return Uni::t(static::$messageCategory, $list[$value]);
        }

        return null;
    }

    /**
     * Returns the list of constants (by name) for this type.
     *
     * @return array The list of constants by name
     */
    public static function getConstantsByName()
    {
        $class = get_called_class();

        if (!isset(self::$byName[$class])) {
            $reflection = new ReflectionClass($class);
            self::$byName[$class] = $reflection->getConstants();
            while (false !== ($reflection = $reflection->getParentClass())) {
                if (__CLASS__ === $reflection->getName()) {
                    break;
                }

                self::$byName[$class] = array_replace(
                    $reflection->getConstants(),
                    self::$byName[$class]
                );
            }
        }

        return self::$byName[$class];
    }

    /**
     * Returns the list of constants (by value) for this type.
     *
     * @return array The list of constants by value
     */
    public static function getConstantsByValue()
    {
        $class = get_called_class();

        if (!isset(self::$byValue[$class])) {
            self::getConstantsByName();

            self::$byValue[$class] = [];

            foreach (self::$byName[$class] as $name => $value) {
                if (array_key_exists($value, self::$byValue[$class])) {
                    if (!is_array(self::$byValue[$class][$value])) {
                        self::$byValue[$class][$value] = [
                            self::$byValue[$class][$value],
                        ];
                    }
                    self::$byValue[$class][$value][] = $name;
                } else {
                    self::$byValue[$class][$value] = $name;
                }
            }
        }

        return self::$byValue[$class];
    }

    /**
     * Returns the name of the value.
     *
     * @return array|string The name, or names, of the value
     */
    public function getName()
    {
        $constants = self::getConstantsByValue();

        return $constants[$this->_value];
    }

    /**
     * Unwraps the type and returns the raw value.
     *
     * @return mixed The raw value managed by the type instance
     */
    public function getValue()
    {
        return $this->_value;
    }

    /**
     * Checks if a name is valid for this type.
     *
     * @param string $name The name of the value
     *
     * @return bool If the name is valid for this type, `true` is returned.
     * Otherwise, the name is not valid and `false` is returned
     */
    public static function isValidName($name)
    {
        $constants = self::getConstantsByName();

        return array_key_exists($name, $constants);
    }

    /**
     * Checks if a value is valid for this type.
     *
     * @param string $value The value
     *
     * @return bool If the value is valid for this type, `true` is returned.
     * Otherwise, the value is not valid and `false` is returned
     */
    public static function isValidValue($value)
    {
        $constants = self::getConstantsByValue();

        return array_key_exists($value, $constants);
    }

    /**
     * Returns a value when called statically like so: MyEnum::SOME_VALUE() given SOME_VALUE is a class constant
     *
     * @param string $name
     * @param array $arguments
     *
     * @return static
     *
     * @throws BadMethodCallException
     */
    public static function __callStatic($name, $arguments)
    {
        $constants = static::getConstantsByName();

        if (isset($constants[$name])) {
            return new static($constants[$name]);
        }

        throw new BadMethodCallException("No static method or enum constant '$name' in class " . get_called_class());
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->_value;
    }
}
