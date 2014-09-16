<?php

namespace Eva {
    abstract class Model {
        protected $db;
        public function __construct(){
            $this->db = \app::$db;
        }
    };
}

namespace Model {
    class PDO extends \PDO {};
}

/// 2014 | AeonRUSH |