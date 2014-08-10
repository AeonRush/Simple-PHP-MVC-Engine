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
    public static function init(){
        if(self::$self == NULL) self::$self = new self();
        return self::$self;
    }
    public function __construct(){
        $this->user = $_SESSION['aeon-user'];
        $this->isAuth = !empty($this->user);
        //TODO: Сделать проверку данных при авторизации. Например при использовании cookie
    }
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
    public function auth(){
        return false;
    }
};

/// 2014 | AeonRUSH |