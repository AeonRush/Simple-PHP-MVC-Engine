<?php

/**
 * Class Fragment
 * Simple call
 *  new \Fragment\Home('index', $this, 'Modern, progressive!');
 * And that's all :)
 */
namespace Eva {
    class Fragment extends Eva {
        public function __construct($method, &$parent_view, $args = NULL){

            if(\app::auth()->isAuth() && method_exists($this, 'secure_'.$method)) {
                $method = 'secure_'.$method;
            };

            if(!method_exists($this, $method)) return false;
            $this->view = $parent_view;
            return $this->$method($args);
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