<?php

/**
 * Class app
 * Базовый класс
 */
final class app {
    public static $db;
	private static $app;
	private static $auth;
    private static $router;
    private static $config;
    private static $local;
    public static function getInstance(){
		if(self::$app != NULL) return self::$app; 
        self::$app = new self();
        
        self::$config = include(__ROOT__.'/config.inc');

        try { 
            self::$db = new PDO('mysql:host=127.0.0.1; dbname='.self::getParam('db:name'), self::getParam('db:user'), self::getParam('db:password'),  array( PDO::ATTR_PERSISTENT => true )); 
    	    self::$db->query('SET character_set_client="utf8", character_set_results="utf8", collation_connection="cp1251_general_ci"');
        }
	    catch(Exception $e){ /* Do nothing */ }

        self::$auth = \Auth::getInstance();
        self::$local = \Local::getInstance();
        self::$local->localeCheck();

        # self::$router = \Router::getInstance();
        $data = array('name' => '"Alexander<script>alert()</script>', 'layer2' => array('name2' => 'Alex<script>alert(2)</script>'));
        self::sanitize($data);
        print_r($data);
        return self::$app;
	}
    public static function getUser(){
        return self::$auth->getUser();
    }
    public static function isAuth(){
        return self::$auth->isAuth();
    }
    public static function getRole(){
        return self::$auth->getRole();
    }
    public static function getParam($key){
        return self::$config[$key];
    }
    public static function locale(){
        return self::$local;
    }
    public static function model($m, $a = NULL) {
        $m = '\Model\\'.$m;
        return new $m($a);
    }
    public static function sanitize(&$a) {
        foreach($a as $k => $v) {
            if(is_array($v)) {
                self::sanitize($a[$k]);
                continue;
            }
            $a[$k] = htmlspecialchars($v);   
        }
    }
};

/// 2014 | AeonRUSH |