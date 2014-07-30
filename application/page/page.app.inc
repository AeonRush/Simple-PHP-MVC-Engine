<?php
    
class Page extends App {
    public function index(){
        $this->view->title = 'Home';
        $this->view->render('index');
    }
    public function skills(){
        $this->view->render('skills');
    }
    public function data(){
        $this->view->render(array("data"));
    }
};