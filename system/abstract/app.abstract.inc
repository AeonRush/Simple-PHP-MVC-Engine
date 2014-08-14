<?php

/**
 * Class App
 */
abstract class App extends Eva {
    protected $view;
    public function __construct(){
        $this->view = new View($this);
        $this->path = __APP__.'/'.strtolower(get_called_class());
    }
    public function render(&$data){
        $this->view->render($data);
    }
};

/// 2014 | AronRUSH |