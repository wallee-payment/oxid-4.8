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



/**
 * Class BasketItem.
 * Extends \oxbasketItem.
 *
 * @mixin \oxbasketItem
 */
class wlewallee_oxbasketitem extends wlewallee_oxbasketitem_parent {
	private static $blWleDisableCheckProduct = false;

	public function getArticle($blCheckProduct = false, $sProductId = null, $blDisableLazyLoading = false){
		return $this->_BasketItem_getArticle_parent(self::$blWleDisableCheckProduct ? false : $blCheckProduct, $sProductId, $blDisableLazyLoading);
	}

	protected function _BasketItem_getArticle_parent($blCheckProduct = false, $sProductId = null, $blDisableLazyLoading = false){
		return parent::getArticle($blCheckProduct, $sProductId, $blDisableLazyLoading);
	}

	public function wleDisableCheckProduct($flag){
		self::$blWleDisableCheckProduct = (boolean) $flag;
	}
}