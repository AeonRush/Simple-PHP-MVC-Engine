<?php

/**
 * Class Locale
 * Класс по работе с языками
 */
class Local {
	public static $self;
    public static function getInstance() {
		if (self::$self == NULL) self::$self = new self();
		return self::$self;
	}

    /**
     * Конструктор класса
     * Загружаем JSON с данными
     */
    public function __construct(){
        /**
         * Если есть APC храним с его помощью
         */
        if(function_exists('apc_exists')) {
            /**
             * Список языков
             */
            if(!apc_exists('languages')) {
                $json = file_get_contents(__SYSTEM__.'/languages.json');    
                apc_add('languages', $json, 60);   
            } 
            else
            {
                $json = apc_fetch('languages');
            }
            /**
             * Список связанных культур и стран
             */
            if(!apc_exists('cultures')) {
                $cultures = file_get_contents(__SYSTEM__.'/cultures.json');
                apc_add('cultures', $json, 60);   
            } 
            else
            {
                $cultures = apc_fetch('cultures');
            } 

        } 
        else 
        {
            /**
             * Если APC нет, то загружаем из файлов
             */
            $json = file_get_contents(__SYSTEM__.'/languages.json');
            $cultures = file_get_contents(__SYSTEM__.'/cultures.json');
        }
        /**
         * Загружаем JSON с данными
         */
        $this->languages = json_decode(preg_replace('/(\xEF\xBB\xBF)+/', '', $json), true);
        $this->cultures = json_decode(preg_replace('/(\xEF\xBB\xBF)+/', '', $cultures), true);
        unset($json);
    }

    /**
     * Проверка текущего языка
     * Если Язык не определен или язык не поддерживается делаем redirect к ближайшему подходящему
     */
    public function localeCheck(){
        $language = NULL;
        preg_match('/^\/([a-z]{2}\-[a-z]{2})[\/]{1}(.*)/', $_SERVER['REQUEST_URI'], $language);

        if(sizeof(\app::getParam('eva:languages')) == 1) {
            if(empty($language)) return;
            header('Location: '.substr($_SERVER['REQUEST_URI'], 6));
            exit;    
        };
        
        $keys = array_keys($this->getSupportedLanguages());
        $default = array_keys($this->getUserLanguages());

        if(!empty($language)){
            $language = (substr($language[1], 0, 2).'-'.strtoupper(substr($language[1], 3, 5)));

            if(!in_array($language, $keys)) {
                header('Location: /'.strtolower($default[0]).substr($_SERVER['REQUEST_URI'], 6));
                exit;
            }
        } else {
            header('Location: /'.strtolower($default[0]).$_SERVER['REQUEST_URI']);
            exit;
        }
    }

    /**
     * Функция возвращает текущий язык
     * @return string
     */
    public function getCurrentLanguage() {
        if(sizeof(\app::getParam('eva:languages')) == 1) {
            $t = \app::getParam('eva:languages');
            return $t[0];
        };
        $language = NULL;
        preg_match('/([a-z]{2}\-[a-z]{2})(.*)/', $_SERVER['REQUEST_URI'], $language);
        return (substr($language[1], 0, 2).'-'.strtoupper(substr($language[1], 3, 2)));
    }

    /**
     * Функция возвращает все языки
     * @return mixed
     */
    public function getAllLanguages(){
        return $this->languages;
    }

    /**
     * Функция возвращает список всех поддерживаемых языков
     * @return array
     */
    public function getSupportedLanguages(){
        $return = array();
        foreach(\app::getParam('eva:languages') as $k => $v) {
            $return[$v] = $this->languages[$v];
        };
        return $return;
    }

    /**
     * Функция возвращает пользовательские языки
     * @return array
     */
    public function getUserLanguages(){
        $lang = array();

        /**
         * Получение языка для страны
         */
        $country = function_exists('geoip_country_code3_by_name') ? geoip_country_code3_by_name($_SERVER['REMOTE_ADDR']) : NULL;
        $country = $this->cultures[$country];
        if(!empty($country)) {
            $lang[] = $country['language-culture-name'];
            unset($country);
        }

        /**
         * Получени языка по заголовку HTTP Accept-Language
         */
        $langs = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
        $lang[] = $langs[0];
        unset($langs[0], $langs[1]);
        
        foreach($langs as $k => $v) {
            $v = explode(';', $v);
            $lang[] = $v[0];
        }; unset($langs);
        array_unique($lang);

        /**
         * Заполнение массива данными о названии языка, культуре и т.д.
         * https://github.com/AeonRush/Simple-PHP-MVC-Engine/blob/master/system/languages.json
         */
        $langs = array();
        foreach($lang as $k2 => $v2) {
            foreach(\app::getParam('eva:languages') as $k => $v) {
                $v1 = substr($v, 0, 2);
                if($v1 == $v2 || $v == $v2) {
                    $langs[$v] = $this->languages[$v];
                    break;
                }
            }
        }
        unset($lang);
        return $langs;
    }
};

/// 2014 | AeonRUSH |