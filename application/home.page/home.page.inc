<?php
namespace Page;
class Home extends \Eva\Page {
    public function index(){
        $this->view->title = $_GET['id'];
        $this->view->render('index');
    }
};