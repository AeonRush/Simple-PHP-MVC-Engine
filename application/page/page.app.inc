<?php
    
class Page extends App {
    public function index(){
        $this->view->title = 'Home';
        $this->view->render('index');
    }
};