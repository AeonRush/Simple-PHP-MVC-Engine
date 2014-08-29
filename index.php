<?php

error_reporting(E_NONE);
session_start();
mb_internal_encoding('UTF-8');

define('__ROOT__', dirname(__FILE__));
define('__SYSTEM__', __ROOT__.'/system');
define('__APP__', __ROOT__.'/application');
define('__HOST__', (empty($_SERVER['REQUEST_SCHEME']) ? 'http' : $_SERVER['REQUEST_SCHEME']).'://'.$_SERVER['HTTP_HOST'].( strtr($_SERVER['PHP_SELF'], array('/index.php' => '') ) ));

ob_start();
    include(__SYSTEM__.'/aeon.php');
    include(__SYSTEM__.'/aeon.headers.php');
    include(__SYSTEM__.'/aeon.auth.php');
    include(__SYSTEM__.'/aeon.router.php');
    include(__SYSTEM__.'/aeon.loader.php');
    include(__SYSTEM__.'/aeon.local.php');
    include(__SYSTEM__.'/aeon.engine.php');
ob_end_clean();
\app::getInstance();

/// 2014 | AeonRUSH |