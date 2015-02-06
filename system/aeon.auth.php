 <?php

/**
 * Class Auth
 * Класс для авторизации
 */
final class Auth {
    private $user;
    private $isAuth;
    private static $self;

    /**
     * @return Auth
     */
    public static function getInstance(){
        if(self::$self == NULL) self::$self = new self();
        return self::$self;
    }
    public function __construct(){
        $this->user = $_SESSION[\app::getParam('auth:session-key')];
        $this->isAuth = !empty($_SESSION[\app::getParam('auth:session-key')]);
        // TODO: Сделать проверку данных при авторизации. Например при использовании cookie
    }

    /**
     * Получение роли пользователя, если нужно.
     * Используется в aeon.router для подключения роутера пользователя
     * @return mixed
     */
    public function getRole(){
        /// IF $this->user['authorized'] == true BUT $this->user['role'] == NULL THEN $this->user['role'] = 'secure' 
        if($this->user['role'] != NULL) return $this->user['role'];
        $this->user['role'] = 'guest';
        if($this->isAuth()) $this->user['role'] = 'secure';
        return $this->user['role'];
    }
    /**
     * Проверка авторизирован ли пользователь или это гость
     * @return bool
     */
    public function isAuth(){
        return $this->isAuth;
    }
    /**
     * Получение данных о пользователе
     * @return bool
     */
    public function getUser(){
        return $this->user['data'] ? $this->user['data'] : false;
    }
    //TODO: DB auth
    public static function auth(){
        return false;
    }

    /**
     * LOGOUT
     */
    public static function out(){
        $_SESSION[\app::getParam('auth:session-key')] = array();
        unset($_SESSION[\app::getParam('auth:session-key')]);
    }

};

/// 2014 | AeonRUSH |