<?php

namespace Eva {
    abstract class Model extends ActiveRecord {
        protected $db;
        public function __construct(){
            $temp = array_clean( explode('\\', get_called_class()) );
            $this->instance = strtolower($temp[1]);
            unset($temp);
            $this->db = \app::$db;
        }
    };
}

namespace Model {
    class PDO extends \PDO {};
}

/// 2014 | AeonRUSH |