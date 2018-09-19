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

require_once(OX_BASE_PATH . "modules/wle/Wallee/autoload.php");



use Monolog\Logger;
use Wle\Wallee\Application\Model\Alert;
use Wle\Wallee\Core\WalleeModule;

/**
 * Class NavigationController.
 * Extends \navigation.
 *
 * @mixin \oxadminview
 */
class wlewallee_navigation extends wlewallee_navigation_parent
{
	public function render() {
		$result = parent::render();
		if($result === 'header.tpl') {
			return 'wleWalleeHeader.tpl';
		}
		return $result;
	}
	
	public function getWleAlerts()
    {
        $alerts = array();
        foreach (Alert::loadAll() as $row) {
            if ($row[1] > 0) {
                switch ($row[0]) {
                    case Alert::KEY_MANUAL_TASK:
                        $alerts[] = array(
                            'func' => $row[2],
                            'target' => $row[3],
                            'title' => WalleeModule::instance()->translate("Manual Tasks (!count)", true, array('!count' => $row[1]))
                        );
                        break;
                    default:
                        WalleeModule::log(Logger::WARNING, "Unkown alert loaded from database: " . array($row));
                }
            }
        }
        return $alerts;
    }
}

