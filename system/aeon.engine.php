<?php

/**
 * Class app
 * Базовый класс
 */
final class app {
    public static $db;
	private static $app;
	private static $auth;
    private static $cache;
    private static $router;
    private static $config;
    private static $extensions;

    /**
     * Singleton
     * @return app
     */
    public static function getInstance(){
		if(self::$app != NULL) return self::$app; 
        self::$app = new self();

        self::$config = include(__ROOT__.'/config.inc');

        include(__SYSTEM__.'/aeon.cache.php');
        self::$cache = new SimpleCache();

        if(self::getParam('db:enabled')) {
            try {
                self::$db = new PDO('mysql:host='.self::getParam('db:server').'; dbname='.self::getParam('db:name'), self::getParam('db:user'), self::getParam('db:password'),  array( PDO::ATTR_PERSISTENT => true ));
                self::$db->query('SET character_set_client="utf8", character_set_results="utf8", collation_connection="cp1251_general_ci"');
            }
            catch(Exception $e){
                error_log('PDO is not supported on this OS! Please, contact your administrator!', 0);
                exit;
            };
        };

        if(__APC__){
            if(apc_exists('helpers-list')) $ext = json_decode(apc_fetch('helpers-list'), true);
            else {
                $ext = glob(__ROOT__.'/helpers/*.php');
                apc_add('helpers-list', json_encode($ext), 60);
            }
        } else {
            $ext = glob(__ROOT__.'/helpers/*.php');
        };

        foreach($ext as $v) {
            include($v);
            $ext_name = substr(basename($v), 0, -4);
            self::$extensions[$ext_name] = $ext_name::getInstance();
        };
        unset($ext);

        self::$auth = \Auth::getInstance();
        self::$router = \Router::getInstance();

        return self::$app;
	}

    /**
     * Simple redirect function
     * @param $url
     */
    public static function redirect($url) {
        header('Location: '.$url);
        exit;
    }

    /**
     * Get param value from config by key
     * @param $key
     * @return mixed
     */
    public static function getParam($key){
        return self::$config[$key];
    }

    /**
     * Return Auth object
     * @return mixed
     */
    public static function auth(){
        return self::$auth;
    }

    /**
     * Create a new model
     * @param $m
     * @param null $a
     * @return mixed
     */
    public static function model($m, $a = NULL) {
        $m = '\Model\\'.$m;
        return new $m($a);
    }

    /**
     * Sanitize array
     * @param $a
     */
    public static function sanitize(&$a) {
        foreach($a as $k => $v) {
            if(is_array($v)) {
                self::sanitize($a[$k]);
                continue;
            }
            $a[$k] = htmlspecialchars($v);   
        }
    }
    public static function postprocess($html){
        # TODO: Написать дописывание языка в URL
        /*
        ob_start();
        $regexp = "<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>(.*)<\/a>";

        if(preg_match_all("/$regexp/siU", $html, $matches, PREG_SET_ORDER)) {
            foreach($matches as $v) {
                echo $v[2].'<br>';
            }
        };
        echo $html;
        $html = ob_get_contents();
        ob_end_clean();
        */
        return $html;
    }

    /**
     * Provide access to extensions
     * Required PHP 5.3+
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public static function __callStatic($name, $arguments) {
        return self::$extensions[$name];
    }
};

/// 2015 : AeonRush