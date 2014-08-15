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
};

/// 2014 | AeonRUSH |