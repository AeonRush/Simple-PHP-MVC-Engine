<?php

error_reporting(E_ALL);
session_start();
mb_internal_encoding('UTF-8');

define('__ROOT__', dirname(__FILE__));
define('__SYSTEM__', __ROOT__.'/system');
define('__APP__', __ROOT__.'/application');
define('__HOST__', (empty($_SERVER['REQUEST_SCHEME']) ? 'http' : $_SERVER['REQUEST_SCHEME']).'://'.$_SERVER['HTTP_HOST'].( strtr($_SERVER['PHP_SELF'], array('/index.php' => '') ) ));

ob_start();
    include(__SYSTEM__.'/aeon.inc');
    include(__SYSTEM__.'/aeon.headers.inc');
    include(__SYSTEM__.'/aeon.auth.inc');
    include(__SYSTEM__.'/aeon.router.inc');
    include(__SYSTEM__.'/aeon.loader.inc');
    include(__SYSTEM__.'/aeon.engine.inc');
ob_end_clean();
__::init();

/// 2014 | AeonRUSH |