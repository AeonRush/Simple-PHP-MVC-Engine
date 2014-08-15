<?php

namespace Fragment;
class Home extends \Eva\Fragment {
    public $data;
    public function index(){
        $this->data = array('key1' => 'Simple, stylish, fast!');
        $this->render('index');
    }
    public function secure_index(){
        $this->data = array('key1' => 'Secure');
        $this->render('index');
    }
};