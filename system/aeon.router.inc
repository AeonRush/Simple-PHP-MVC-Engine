<?php

class Router {
    private static $self;
    private $rules = array();
    private $httpMethod = 'get';
	
    public static function init(){
		if(self::$self == NULL) self::$self = new self();
        return self::$self;
    }
    public function __construct(){
        if(!empty($_POST) && !empty($_FILES)) $this->httpMethod = 'post&files';
        elseif(!empty($_POST)) $this->httpMethod = 'post';
        elseif(!empty($_FILES)) $this->httpMethod = 'files';
        
		$_SERVER['REQUEST_URI'] = iconv('cp1251', 'utf-8', substr($_SERVER['REQUEST_URI'], ($_SERVER['REQUEST_URI'][1] == '?') ? 2 : 1));
        
        $files = glob(__APP__.'/*/routes.inc');
        foreach($files as $k => $v) {
            $this->rules = array_merge($this->rules, include($v));
        };
        unset($files);
        
        if(__::isAuth()) {
            $files = glob(__APP__.'/*/routes.'.__::getRole().'.inc');
            foreach($files as $k => $v) {
                $this->rules = array_merge($this->rules, include($v));
            };
            unset($files);
        };

		foreach($this->rules as $template => $params) {
            $url = explode(':', $template);

            $url[1] = !$url[1] ? 'get' : $url[1];
            if($url[1] !== $this->httpMethod) continue;

			$matches = array();
            if(preg_match('/'.str_replace('/', '\/', $url[0]).'/', $_SERVER['REQUEST_URI'], $matches) == true) {
				$e = explode('?', $params);	
                $i = sizeof($matches);
				for($j=1;$j<$i; ++$j){ $e[1] = str_replace('$'.$j, $matches[$j], $e[1]); };
			
				$e[1] = strtr( mysql_escape_string(urldecode( $e[1] ) ), array('=' => '":"', '&' => '","'));
				if(isset($e[1]{5})) $_GET = array_merge($_GET, json_decode('{"'.$e[1].'"}', true));
				
                $class = explode('/', $e[0]);
                $e = new $class[0]();
                if(method_exists($e, $class[1])) $e->$class[1]();
                else { 
                    unset($class, $e, $url, $matches);
                    msg404(true);
                }
                unset($class, $e, $url, $matches);
                return;
			};
		};
		msg404(true);
	}	
};

/// 2014 | AeonRUSH |