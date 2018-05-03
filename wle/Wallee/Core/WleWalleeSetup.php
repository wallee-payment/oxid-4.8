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

require_once(OX_BASE_PATH . 'modules/wle/Wallee/autoload.php');

use Wle\Wallee\Core\WalleeModule;

/**
 * Wrapper for installation events, as defining WalleeModule would interfere with our autoloader.
 * 
 * @author sebastian
 *
 */
class WleWalleeSetup {
	public static function onActivate(){
		WalleeModule::onActivate();
	}
	
	public static function onDeactivate() {
		WalleeModule::onDeactivate();
	}
}