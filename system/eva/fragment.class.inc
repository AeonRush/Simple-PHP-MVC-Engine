<?php

/**
 * Class Fragment
 */
namespace Eva {
    class Fragment extends Eva {
        public function __construct($method, $view){
            if(method_exists($this, $method))
            $this->view = $view;

            if(\app::isAuth() && method_exists($this, 'secure_'.$method)) {
                $method = 'secure_'.$method;
            };

            echo $this->$method();
        }
        protected function render($view) {
            include(__APP__.'/'.str_replace('fragment\\', '', strtolower(get_called_class())).'.fragment/view/'.$view.'.view.phtml');
        }
    };
}

namespace Fragment {
    class PDO extends \PDO {};
}

/// 2014 | AeonRUSH |