<?php

/**
 * Class Fragment
 */
class Fragment extends Eva {
    public function __construct($method, $view){
        if(method_exists($this, $method))
        $this->view = $view;

        if(__::isAuth() && method_exists($this, 'secure_'.$method)) {
            $method = 'secure_'.$method;
        };

        echo $this->$method();
    }
    protected function render($view) {
        include(__APP__.'/'.strtolower(get_called_class()).'.fragment/view/'.$view.'.view.phtml');
    }
};

/// 2014 | AeonRUSH |