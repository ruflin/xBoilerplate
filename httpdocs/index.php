<?php

/**
 * Xodoa mini CMS
 *
 * To reuse or modify this code permission of xodoa.com is necessary.
 *
 * @category Xodoa
 * @package  Xodoa
 * @copyright Copyright (c) 2007-2011 Xodoa (http://xodoa.com)
 * @author   Nicolas Ruflin <ruflin@xodoa.com>
 */
ini_set('error_log', '/tmp/php-error.log');

error_reporting(E_ALL|E_STRICT);

// adds elasticsearch to the include path
set_include_path(get_include_path() . PATH_SEPARATOR . realpath(dirname(__FILE__) . '/../lib'));

function xodoa_autoload($class) {
	$file = str_replace('_', '/', $class) . '.php';
	require_once $file;
}

spl_autoload_register('xodoa_autoload');

$content = '';
try {
	$uri = $_SERVER['REQUEST_URI'];

	// Load css
	if (substr($uri, 1,3) == 'css') {
		$less = new lessc('css/' . $_GET['f']);
		$content = $less->parse();
	} else {
		$xodoa = new Xodoa($_SERVER['REQUEST_URI'], $_GET);
		$content = $xodoa->render();
	}


} catch(Exception $e) {
	error_log(print_r($e, true));
	print_r($e);
}

echo $content;
