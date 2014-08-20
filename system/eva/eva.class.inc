<?php

/**
 * Class Eva
 */
namespace Eva;
class Eva extends \ArrayIterator {
    protected $__data__;
    public function __get($name) {
        return $this->__data__[$name];
    }
    public function __set($name, $value) {
        $this->__data__[$name] = $value;
    }
    public function __call($name, $arguments)
    {
        // Note: value of $name is case sensitive.
        if(!method_exists(array($this, $name))) return;
    }

    /**  As of PHP 5.3.0  */
    public static function __callStatic($name, $arguments)
    {
        if(!method_exists(array($this, $name))) return;
    }
};

/// 2014 | AeonRUSH |