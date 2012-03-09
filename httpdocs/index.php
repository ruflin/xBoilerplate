<?php

/**
 * xBoilerplate: Xodoa Boilerplate
 *
 * @category xBoilerPlate
 * @package  Xodoa
 * @copyright Copyright (c) 2007-2012 Xodoa (http://xodoa.com)
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
	$uri = parse_url($_SERVER['REQUEST_URI']);

	// Load css
	if (substr($uri['path'], 1,3) == 'css') {
		header('Content-Type: text/css');

		$less = new lessc(substr($uri['path'], 1));
		//print_r($less);
		$content = $less->parse();
		echo $content;
		exit();
	} else {
		$xBoilerplate = new xBoilerplate($uri['path'], $_GET);
		$content = $xBoilerplate->render();
	}
} catch(Exception $e) {
	error_log(print_r($e, true));
	print_r($e);
}

echo $content;

