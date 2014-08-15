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
<<<<<<< HEAD
        spl_autoload_register(array($this, 'preprocess'));
=======
		spl_autoload_register(array($this, 'apps'));
		spl_autoload_register(array($this, 'classes'));
        spl_autoload_register(array($this, 'models'));
		spl_autoload_register(array($this, 'abstracts'));
		spl_autoload_register(array($this, 'fragments'));
		spl_autoload_register(array($this, 'distributed'));
>>>>>>> origin/master
	}
    private function load($class, $path, $ext = '.inc') {
        $class = strtolower($class);
        if(class_exists($class)) return;
		spl_autoload_extensions($ext);
    	set_include_path($path);
		spl_autoload($class);
    }
<<<<<<< HEAD
    public function preprocess($class){
        if(class_exists($class)) return;
        $class = explode('/', strtolower(strtr($class, '\\', '/')));
        $class[0] .= 's';
        $this->$class[0]($class[1]);
    }
    public function pages($class) {
        include (__APP__.'/'.$class.'.page/'.$class.'.page.inc');
    }
    public function fragments($class) {
        include (__APP__.'/'.$class.'.fragment/'.$class.'.fragment.inc');
    }
    public function models($class) {
        include (__ROOT__.'/model/'.$class.'.model.inc');
    }
    public function evas($class) {
        include (__ROOT__.'/system/eva/'.$class.'.class.inc');
    }
=======
	public function apps($class){
        $this->load($class, __APP__.'/'.strtolower($class), '.app.inc');
	}
	public function fragments($class){
        $this->load($class, __APP__.'/'.strtolower($class).'.fragment', '.fragment.inc');
	}
    public function models($class){
        if(class_exists($class)) return;
        $class = str_replace('model', '', strtolower($class));
        include(__ROOT__.'/model/'.$class.'.model.inc');
    }
	public function abstracts($class){
        $this->load($class, __SYSTEM__.'/abstract', '.abstract.inc');
	}
	public function classes($class){
        $this->load($class, __SYSTEM__.'/class', '.class.inc');
	}
	public function distributed($class){
        $this->load($class, __ROOT__.'/distributed');
	}
>>>>>>> origin/master
}; AEONLoader::init();

/// 2014 | AeonRUSH |