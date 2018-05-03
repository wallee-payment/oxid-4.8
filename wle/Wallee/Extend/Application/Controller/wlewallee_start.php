<?php
/**
 * Wallee OXID
 *
 * This OXID module enables to process payments with Wallee (https://www.wallee.com/).
 *
 * @package Whitelabelshortcut\Wallee
 * @author customweb GmbH (http://www.customweb.com/)
 * @license http://www.apache.org/licenses/LICENSE-2.0  Apache Software License (ASL 2.0)
 */require_once(OX_BASE_PATH . "modules/wle/Wallee/autoload.php");



use Wle\Wallee\Application\Controller\Cron;


/**
 * Class used to include tracking device id on basket.
 *
 * Class BasketController.
 * Extends \start.
 *
 * @mixin \start
 */
class wlewallee_start extends wlewallee_start_parent
{
    public function render()
    {
        $this->_aViewData['wleCronUrl'] = Cron::getCronUrl();
        return $this->_StartController_render_parent();
    }

    protected function _StartController_render_parent()
    {
        return parent::render();
    }
}