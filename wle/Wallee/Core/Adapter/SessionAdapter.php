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
namespace Wle\Wallee\Core\Adapter;
require_once(OX_BASE_PATH . 'modules/wle/Wallee/autoload.php');

use Wallee\Sdk\Model\AbstractTransactionPending;
use Wallee\Sdk\Model\TransactionCreate;
use Wallee\Sdk\Model\TransactionPending;
use Wle\Wallee\Core\WalleeModule;
use Wle\Wallee\Application\Model\Transaction;

/**
 * Class SessionAdapter
 * Converts Oxid Session Data into data which can be fed into the Wallee SDK.
 *
 * @codeCoverageIgnore
 */
class SessionAdapter implements ITransactionServiceAdapter {
	private $session = null;
	private $basketAdapter = null;
	private $addressAdapter = null;

	/**
	 * SessionAdapter constructor.
	 *
	 * Checks if user is logged in and basket is present as well, and throws an exception if either is not present.
	 *
	 * @param \oxsession $session
	 * @throws \Exception
	 */
	public function __construct(\oxsession $session){
		if (!$session->getUser() || !$session->getBasket()) {
			throw new \Exception("User must be logged in and basket must be present.");
		}
		$this->session = $session;
		$this->basketAdapter = new BasketAdapter($session->getBasket());
		$this->addressAdapter = new AddressAdapter($session->getUser()->getSelectedAddress(), $session->getUser());
	}

	public function getCreateData(){
		$transactionCreate = new TransactionCreate();
		if (isset($_COOKIE['Wallee_device_id'])) {
			$transactionCreate->setDeviceSessionIdentifier($_COOKIE['Wallee_device_id']);
		}
		$transactionCreate->setAutoConfirmationEnabled(false);
		$this->applyAbstractTransactionData($transactionCreate);
		return $transactionCreate;
	}

	public function getUpdateData(Transaction $transaction){
		$transactionPending = new TransactionPending();
		$transactionPending->setId($transaction->getTransactionId());
		$transactionPending->setVersion($transaction->getVersion());
		$this->applyAbstractTransactionData($transactionPending);
		
		if ($transaction->getOrderId()) {
			$transactionPending->setFailedUrl(
					WalleeModule::getControllerUrl('order', 'wleError', $transaction->getOrderId()));
class_exists('oxorder');			$order = oxNew('oxorder');
			/* @var $order \oxorder */
			if ($order->load($transaction->getOrderId())) {
				$transactionPending->setMerchantReference($order->oxorder__oxordernr->value);
				$transactionPending->setAllowedPaymentMethodConfigurations(
						array(
							WalleeModule::extractWalleeId($order->oxorder__oxpaymenttype->value) 
						));
			}
		}
		
		return $transactionPending;
	}

	private function applyAbstractTransactionData(AbstractTransactionPending $transaction){
		$transaction->setCustomerId($this->session->getUser()->getId());
		$transaction->setCustomerEmailAddress($this->session->getUser()->getFieldData('oxusername'));
		/**
		 * @noinspection PhpUndefinedFieldInspection
		 */
		$transaction->setCurrency($this->session->getBasket()->getBasketCurrency()->name);
		$transaction->setLineItems($this->basketAdapter->getLineItemData());
		$transaction->setBillingAddress($this->addressAdapter->getBillingAddressData());
		$transaction->setShippingAddress($this->addressAdapter->getShippingAddressData());
		$transaction->setLanguage(\oxregistry::getLang()->getLanguageAbbr());
		$transaction->setSuccessUrl(WalleeModule::getControllerUrl('thankyou'));
		$transaction->setFailedUrl(WalleeModule::getControllerUrl('order', 'wleError'));
	}
}