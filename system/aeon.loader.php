<?php

/**
 * Class AEONLoader
 * Класс автоматической загрузки классов и интерфейсов
 */
class AEONLoader {
	public static $loader;

    /**
     * Singleton
     * @return AEONLoader
     */
    public static function getInstance() {
		if (self::$loader == NULL) self::$loader = new self();
		return self::$loader;
	}
	public function __construct() {
        spl_autoload_register(array($this, 'preprocess'));
	}

    /**
     * Detecting what kind of class we initialize
     * Example
     * \Model\simple
     * |_____||_____|
     *   Type  Name
     * @param $class
     */
    public function preprocess($class){
        if(class_exists($class)) return;
        $class = array_clean(  explode('/', strtolower(strtr($class, '\\', '/'))) );

        $class[0] .= 's';
        $this->$class[0]($class[1]);
    }

    /**
     * Pages loading
     * /application/$class.page/$class.page.php
     * class $class extends \Eva\Page
     * @param $class
     */
    public function pages($class) {
        include (__APP__.'/'.$class.'.page/'.$class.'.page.php');
    }

    /**
     * Fragments loading
     * /application/$class.fragment/$class.fragment.php
     * class $class extends \Eva\Fragment
     * @param $class
     */
    public function fragments($class) {
        include (__APP__.'/'.$class.'.fragment/'.$class.'.fragment.php');
    }

    /**
     * Models load
     * /model/
     * class $class
     * @param $class
     */
    public function models($class) {
        include (__ROOT__.'/model/'.$class.'.model.php');
    }

    /**
     * Standard classes load
     * /system/$class.class.php
     * @param $class
     */
    public function evas($class) {
        include (__ROOT__.'/system/eva/'.$class.'.class.php');
    }
}; AEONLoader::getInstance();

/// 2014 | AeonRUSH |