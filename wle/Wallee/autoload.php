<?php
/**
 * Wallee OXID
 *
 * This OXID module enables to process payments with Wallee (https://www.wallee.com/).
 *
 * @package Whitelabelshortcut\Wallee
 * @author customweb GmbH (http://www.customweb.com/)
 * @license http://www.apache.org/licenses/LICENSE-2.0  Apache Software License (ASL 2.0)
 */
require_once(OX_BASE_PATH . 'modules/wle/Wallee/wallee-sdk/autoload.php');

/**
 * Autoload function.
 *
 * This function will resolve \Wle\\Wallee\\ classes to their correct files, as well as the mocked Monolog\Logger
 *
 * @param string $class the fully-qualified class name.
 */
spl_autoload_register(function ($class) {
	// base directory for the namespace prefix
	$base_dir = __DIR__ . "/";
	
	// Mocked Monolog\Logger
	if($class == 'Monolog\Logger') {
		require $base_dir. "Logger/Logger.php";
		return;
	}
	// project-specific namespace prefix
	$prefix = 'Wle\\Wallee\\';

	// does the class use the namespace prefix?
	$len = strlen($prefix);
	if (strncmp($prefix, $class, $len) !== 0) {
		// no, move to the next registered autoloader
		return;
	}

	// get the relative class name
	$relative_class = substr($class, $len);

	// replace the namespace prefix with the base directory, replace namespace
	// separators with directory separators in the relative class name, append
	// with .php
	$file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

	// if the file exists, require it
	if (file_exists($file)) {
		require $file;
	}
}, true, true);