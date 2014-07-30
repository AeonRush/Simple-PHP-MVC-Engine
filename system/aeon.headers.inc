<?php

header('X-Powered-By: AEON Web Engine');
header('X-Powered-By-Version: v2.Alpha');
/**
 * Записывает код 404 в заголовок ответа
 * @param bool $terminate   немедленнно прекратить выролнение скрипта
 */
function msg404($terminate = false){ header( 'HTTP/1.1 404 Not Found', true, 404 ); noCache(); if($terminate) exit; };

/**
 * IF-MODIFIED-SINCE для поисковиков и для кэширования PHP
 * @param $etag
 * @return bool
 */
function ModifiedSince($etag){
	$etag = hash('sha512', $etag);
	header('Etag: '.$etag);
	if($_SERVER['HTTP_IF_MODIFIED_SINCE'] && $_SERVER['HTTP_IF_NONE_MATCH'] == $etag){
		header('HTTP/1.1 304 Not Modified', true, 304);
		return false;
	};
	return true;
};
/**
 * Записывает заголовки даты полседней модификации и правил кэширования
 * @param $time
 */
function LastModified($time){
	header('Last-modified: '.(gmdate('D, d M Y H:i:s \G\M\T', $time)));
	header('Cache-control: no-cache, private, must-revalidate');
    header_remove('Pragma');
	header('Expires: '.(gmdate('D, d M Y H:i:s', time() + 604800).' GMT'));
};
/**
 * Принудительно отключает заголовки кэширования
 */
function noCache(){
	header('Cache-control: no-store, no-cache, must-revalidate, max-age=0');
    header('Pragma: no-cache');
	header('Expires: '.(gmdate('D, d M Y H:i:s', time() - 604800).' GMT'));
};

/// 2014 | AeonRUSH |