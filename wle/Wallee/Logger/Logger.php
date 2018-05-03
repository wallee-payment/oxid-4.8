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
/*
 * Mocks the Monolog/Logger class methods and constants used by the plugin.
 */

namespace Monolog;
require_once(OX_BASE_PATH . 'modules/wle/Wallee/autoload.php');

if(!class_exists("Logger")) {
	class Logger {
		const DEBUG = 100;
		
		const INFO = 200;
		
		const NOTICE = 250;
		
		const WARNING = 300;
		
		const ERROR = 400;
		
		const CRITICAL = 500;
		
		const ALERT = 550;
		
		const EMERGENCY = 600;
		
		public function addRecord($level, $message, $context = null) {
			if($context == null) {
				$context = "";
			}else			if(is_object($context) || is_array($context)) {
				$context = " | " . print_r($context, true);
			}else {
				$context = " | " . (string) $context;
			}
			file_put_contents(OX_BASE_PATH . "log/Wallee.log", date('Y-m-d H:i:s') . " ($level) | " . $message . $context . "\n", FILE_APPEND);
		}
	}
}