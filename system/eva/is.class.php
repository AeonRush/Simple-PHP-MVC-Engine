<?php
    
namespace Eva;

class Is {
    public static function email($e) {
        return preg_match('/^[a-zA-Z0-9_-]+([.][a-zA-Z0-9_-]+)*[@][a-zA-Z0-9_-]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $email);
    }
    public static function login($l) {
        return preg_match('/^[^_\-0-9][A-z0-9_]{3,32}$/', $l);
    }
    public static function password($p) {
        return preg_match('/^[a-zA-Z0-9-_+-=*()]{6,32}$/', $p);
    }
};

/// 2014 | AeonRUSH |