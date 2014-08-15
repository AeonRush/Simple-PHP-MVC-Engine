<?php

/**
 * Class View
 */
namespace Eva;
class View extends Eva {
    public $layout = 'default/default';
    public $page;
    public function __construct(&$page) {
        $this->page = $page;
    }
    public function add($k, $v){
        $k = explode(':', $k);
        if(!in_array($k[1], array('inline', 'src'))) {
            $v = '/'.$k[1].'/'.$v;
            $k[1] = 'src';
        };
        $this[$k[0]][$k[1]][] = $v;
    }
    public function render($data){
        if(!is_string($data)) return $this->ajax($data);
        return $this->layout($data);
    }
    private function layout($view){
        ob_start();
        include($this->page->path.'/view/'.$view.'.view.phtml');
        $this->content = ob_get_contents();
        ob_end_clean();
        ob_start();
        include(__ROOT__.'/layout/'.$this->layout.'.layout.phtml');
        $this->content = ob_get_contents();
        ob_end_clean();
        echo aeon_pack(optimize($this->content));
    }
    private function ajax(&$data){
        echo json_encode($data);
        return;
    }
};

/// 2014 | AeonRUSH |