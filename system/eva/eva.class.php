<?php

/**
 * Class Eva
 */
namespace Eva {
    class Eva extends \ArrayIterator {
        protected $__data__;
        public function __get($name) {
            return $this->__data__[$name];
        }
        public function __set($name, $value) {
            $this->__data__[$name] = $value;
        }
        public function __unset($name) {
            unset($this->__data__[$name]);
        }
        public function __call($name, $a)
        {
            // Note: value of $name is case sensitive.
            if(!method_exists($this, $name)) return;
        }

        /**
         * As of PHP 5.3.0
         * @param $name
         * @param $a
         */
        public static function __callStatic($name, $a)
        {
            if(!method_exists(self, $name)) return;
        }
    };
    class PDO extends \PDO {};
}

/// 2014 | AeonRUSH |