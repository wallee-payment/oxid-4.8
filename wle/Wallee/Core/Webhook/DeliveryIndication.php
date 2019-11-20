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
namespace Wle\Wallee\Core\Webhook;
require_once(OX_BASE_PATH . 'modules/wle/Wallee/autoload.php');

use Wle\Wallee\Core\WalleeModule;

/**
 * Webhook processor to handle delivery indication state transitions.
 */
class DeliveryIndication extends AbstractOrderRelated {

	/**
	 *
	 * @see AbstractOrderRelated::load_entity()
	 * @return \Wallee\Sdk\Model\DeliveryIndication
	 */
	protected function loadEntity(Request $request){
		$service = new \Wallee\Sdk\Service\DeliveryIndicationService(WalleeModule::instance()->getApiClient());
		return $service->read($request->getSpaceId(), $request->getEntityId());
	}

	protected function getOrderId($deliveryIndication){
		/* @var \Wallee\Sdk\Model\DeliveryIndication $delivery_indication */
		return $deliveryIndication->getTransaction()->getMerchantReference();
	}

	protected function getTransactionId($deliveryIndication){
		/* @var $delivery_indication \Wallee\Sdk\Model\DeliveryIndication */
		return $deliveryIndication->getLinkedTransaction();
	}

	protected function processOrderRelatedInner(\oxorder $order, $deliveryIndication){
		/* @var \Wallee\Sdk\Model\DeliveryIndication $deliveryIndication */
		switch ($deliveryIndication->getState()) {
			case \Wallee\Sdk\Model\DeliveryIndicationState::MANUAL_CHECK_REQUIRED:
				$this->review($order);
				break;
			default:
				// Nothing to do.
				break;
		}
	}

	protected function review(\oxorder $order){
		$order->getWalleeTransaction()->pull();
		$order->setWalleeState($order->getWalleeTransaction()->getState());
	}
}