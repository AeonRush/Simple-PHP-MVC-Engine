<?php

/**
 * Class __
 */
final class __ {
    public static $db;
	private static $app;
	private static $auth;
    private static $router;
    private static $config;
    public static function init(){
		if(self::$app != NULL) return self::$app; 
        self::$app = new self();
        
        self::$config = include(__ROOT__.'/config.inc');

        try { 
            self::$db = new PDO('mysql:host=127.0.0.1; dbname='.self::getParam('db:name'), self::getParam('db:user'), self::getParam('db:password'),  array( PDO::ATTR_PERSISTENT => true )); 
    	    self::$db->query('SET character_set_client="utf8", character_set_results="utf8", collation_connection="cp1251_general_ci"');
        }
	    catch(Exception $e){ /* Do nothing */ }

        self::$auth = Auth::init();
        self::$router = Router::init();
        
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
    public static function getParam($key) {
        return self::$config[$key];
    }
};

/// 2014 | AeonRUSH |