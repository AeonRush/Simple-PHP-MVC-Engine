<?php

/**
 * Class App
 */
namespace Eva;
abstract class Page extends Eva {
    protected $view;
    public function __construct(){
        $this->view = new View($this);
        $path = explode('\\', get_called_class());
        $path = $path[1].'.'.$path[0];
        $this->path = __APP__.'/'.strtolower($path);
    }
    public function render($data){
        $this->view->render($data);
    }
};

/// 2014 | AeonRUSH |