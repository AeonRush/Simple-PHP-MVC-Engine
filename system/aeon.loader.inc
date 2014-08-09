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
		spl_autoload_register(array($this, 'apps'));
		spl_autoload_register(array($this, 'fragments'));
		spl_autoload_register(array($this, 'classes'));
		spl_autoload_register(array($this, 'abstracts'));
		spl_autoload_register(array($this, 'distributed'));
	}
    private function load($class, $path, $ext = '.inc') {
        if(class_exists($class)) return;
		spl_autoload_extensions($ext);
    	set_include_path($path);
		spl_autoload($class);
    }
	public function apps($class){
        $this->load($class, __APP__.'/'.$class, '.app.inc');
	}
	public function fragments($class){
        $this->load($class, __APP__.'/'.$class.'.fragment', '.fragment.inc');
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
}; AEONLoader::init();

/// 2014 | AeonRUSH |