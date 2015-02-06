<?php

error_reporting(0);
session_start();
mb_internal_encoding('UTF-8');

define('__ROOT__', dirname(__FILE__));
define('__SYSTEM__', __ROOT__.'/system');
define('__APP__', __ROOT__.'/application');
define('__HOST__', ('//'.$_SERVER['HTTP_HOST']));
define('__APC__', function_exists('apc_exists'));

ob_start();
    include(__SYSTEM__.'/aeon.php');
    # include(__SYSTEM__.'/aeon.tracer.php');
    include(__SYSTEM__.'/aeon.headers.php');
    include(__SYSTEM__.'/aeon.auth.php');
    include(__SYSTEM__.'/aeon.router.php');
    include(__SYSTEM__.'/aeon.loader.php');
    include(__SYSTEM__.'/aeon.engine.php');
ob_end_clean();
\app::getInstance();

/// 2014 | AeonRUSH |