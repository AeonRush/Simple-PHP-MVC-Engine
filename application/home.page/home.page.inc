<?php
namespace Page;
class Home extends \Eva\Page {
    public function index(){
        $this->view->title = 'Home';
        $this->view->render('index');
    }
};