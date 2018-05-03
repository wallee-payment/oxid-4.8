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



use Wle\Wallee\Extend\Application\Model\Order;

/**
 * Class NavigationController.
 * Extends \order_list.
 *
 * @mixin \order_list
 */
class wlewallee_order_list extends wlewallee_order_list_parent
{
    protected $_sThisTemplate = 'wleWalleeOrderList.tpl';

    public function render()
    {
        $orderId = $this->getEditObjectId();
        if ($orderId != '-1' && isset($orderId)) {
class_exists('oxorder');        	$order = oxNew('oxorder');
            $order->load($orderId);
            /* @var $order Order */

            if ($order->isWleOrder()) {
                $this->_aViewData['wleEnabled'] = true;
            }
        }
        $this->_OrderList_render_parent();

        return $this->_sThisTemplate;
    }

    protected function _OrderList_render_parent()
    {
        return parent::render();
    }
}