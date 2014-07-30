<?php

final class __ {
    public static $pdo;
	private static $app;
	private static $auth;
    private static $router;
    public static function init(){
		if(self::$app != NULL) return self::$app; 
        self::$app = new self();
        
        try { 
            self::$pdo = new PDO('mysql:host=127.0.0.1; dbname=demo', 'root', '123321',  array( PDO::ATTR_PERSISTENT => true )); 
    	    self::$pdo->query('SET character_set_client="utf8", character_set_results="utf8", collation_connection="cp1251_general_ci"');
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
};

/// 2014 | AeonRUSH |