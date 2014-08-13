<?php

error_reporting(0);
session_start();
ob_start();
include(__DIR__.'/system/aeon.inc');
include(__DIR__.'/system/aeon.headers.inc');

$__mime = array(
	'css'	=> 'text/css',
	'js'	=> 'application/x-javascript',
	'jpg'	=> 'image/jpeg',
	'png'	=> 'image/png',
    'svg'   => 'image/svg+xml',
    'woff'  => 'application/font-woff',
    'ttf'   => 'application/x-font-ttf'
);

$_SERVER['REQUEST_URI'] = substr($_SERVER['REQUEST_URI'], 1);
$_SERVER['REQUEST_URI'] = str_replace('public/', '', $_SERVER['REQUEST_URI']);
$_SERVER['REQUEST_URI'] = preg_replace('/[\/]/', '/view/', $_SERVER['REQUEST_URI'], 1);
$_SERVER['REQUEST_URI'] = preg_replace('/layout(\/(.*)\/)?view/', 'layout/$2', $_SERVER['REQUEST_URI'], 1);
$_SERVER['REQUEST_URI'] = str_replace('layout/view', 'layout', $_SERVER['REQUEST_URI']);

$file = __DIR__.'/application/'.$_SERVER['REQUEST_URI'];

if(!file_exists($file)) msg404(true);

header('Content-type: '.$__mime[substr($file, strrpos($file, '.', -4)+1)]);

$fileTime = max(filemtime($file), filemtime(__FILE__));
LastModified($fileTime);
if(!ModifiedSince($fileTime.$_SERVER['REQUEST_URI'])) exit;
ob_end_clean();
echo file_get_contents($file);

/// 2014 | AeonRUSH |