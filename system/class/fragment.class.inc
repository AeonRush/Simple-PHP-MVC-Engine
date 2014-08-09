<?php

/**
 * Class Fragment
 */
class Fragment extends Eva {
    public function __construct($method){
        echo $this->$method();    
    }
};

/// 2014 | AeonRUSH |