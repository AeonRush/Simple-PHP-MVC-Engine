<?php
    
namespace Eva;
/**
 * Class Is
 * Simple testing class
 * @package Eva
 */
class Is {
    /**
     * Test value to matching pattern
     * @param $e
     * @return int
     */
    public static function email($e) {
        return preg_match('/^[a-zA-Z0-9_-]+([.][a-zA-Z0-9_-]+)*[@][a-zA-Z0-9_-]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $e);
    }

    /**
     * Test value to matching pattern
     * @param $l
     * @return int
     */
    public static function login($l) {
        return preg_match('/^[^_\-0-9][A-z0-9_]{3,32}$/', $l);
    }

    /**
     * Test value to matching pattern
     * @param $p
     * @return int
     */
    public static function password($p) {
        return preg_match('/^[a-zA-Z0-9-_+-=*()]{6,32}$/', $p);
    }
};

/// 2014 | AeonRUSH |