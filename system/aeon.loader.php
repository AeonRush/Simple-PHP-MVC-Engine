<?php

/**
 * Class AEONLoader
 * Класс автоматической загрузки классов и интерфейсов
 */
class AEONLoader {
	public static $loader;
    public static function init() {
		if (self::$loader == NULL) self::$loader = new self();
		return self::$loader;
	}
	public function __construct() {
        spl_autoload_register(array($this, 'preprocess'));
	}
    public function preprocess($class){
        if(class_exists($class)) return;
        $class = array_clean(  explode('/', strtolower(strtr($class, '\\', '/'))) );

        $class[0] .= 's';
        $this->$class[0]($class[1]);
    }
    public function pages($class) {
        include (__APP__.'/'.$class.'.page/'.$class.'.page.php');
    }
    public function fragments($class) {
        include (__APP__.'/'.$class.'.fragment/'.$class.'.fragment.php');
    }
    public function models($class) {
        include (__ROOT__.'/model/'.$class.'.model.php');
    }
    public function evas($class) {
        include (__ROOT__.'/system/eva/'.$class.'.class.php');
    }
}; AEONLoader::init();

/// 2014 | AeonRUSH |