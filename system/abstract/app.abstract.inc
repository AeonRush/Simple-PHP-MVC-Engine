<?php

abstract class App extends Eva {
    protected $view;
    public function __construct(){
        $this->view = new View(&$this);
        $this->path = __APP__.'/'.strtolower(get_called_class());
    }
};