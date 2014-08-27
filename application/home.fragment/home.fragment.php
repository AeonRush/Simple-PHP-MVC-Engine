<?php

namespace Fragment;
class Home extends \Eva\Fragment {
    public $data;
    public function index($data){
        $this->data = $data;
        $this->render('index');
    }
    public function secure_index(){
        $this->data = array('key1' => 'Secure');
        $this->render('index');
    }
};