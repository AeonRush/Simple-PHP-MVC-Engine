<?php
namespace Page;
class Home extends \Eva\Page {
    public function index(){
        # $data = \app::model('test')->where('id = 45324')->select('*');
        $this->view->title = 'Simple MVC PHP Engine';
        $this->view->render('index');
    }
};