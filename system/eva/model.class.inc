<?php

namespace Eva;
abstract class Model extends Eva {
    protected $db;
    public function __construct(){
        $this->db = \app::$db;
    }
};

/// 2014 | AeonRUSH |