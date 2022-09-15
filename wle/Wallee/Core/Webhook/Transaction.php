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

use Monolog\Logger;
use Wallee\Sdk\Model\TransactionState;
use Wallee\Sdk\Service\TransactionService;
use Wle\Wallee\Core\WalleeModule;
use Wle\Wallee\Extend\Application\Model\Order;

/**
 * Webhook processor to handle transaction state transitions.
 */
class Transaction extends AbstractOrderRelated
{
    /**
     * Retrieves the entity from Wallee via sdk.
     *
     * @param Request $request
     * @return \Wallee\Sdk\Model\Transaction
     * @throws \Wallee\Sdk\ApiException
     */
    protected function loadEntity(Request $request)
    {
        $service = new TransactionService(WalleeModule::instance()->getApiClient());
        return $service->read($request->getSpaceId(), $request->getEntityId());
    }

    protected function getOrderId($transaction)
    {
        /* @var \Wallee\Sdk\Model\Transaction $transaction */

class_exists(\Wle\Wallee\Application\Model\Transaction::class);        $dbTransaction = oxNew(\Wle\Wallee\Application\Model\Transaction::class);
        /* @var $dbTransaction \Wle\Wallee\Application\Model\Transaction */
        $dbTransaction->loadByTransactionAndSpace($transaction->getId(), $transaction->getLinkedSpaceId());
        return $dbTransaction->getOrderId();
    }

    protected function getTransactionId($transaction)
    {
        /* @var \Wallee\Sdk\Model\Transaction $transaction */
        return $transaction->getId();
    }

    /**
     * @param Order $order
     * @param object $entity
     * @throws \Exception
     */
    protected function processOrderRelatedInner(\oxorder $order, $entity)
    {
        $finalStates = [
            TransactionState::FAILED,
            TransactionState::VOIDED,
            TransactionState::DECLINE,
            TransactionState::FULFILL
        ];

        /* @var $entity \Wallee\Sdk\Model\Transaction */
        if (in_array($entity->getState(), $finalStates)) {
            return false;
        }

        /* @var $order \Wle\Wallee\Extend\Application\Model\Order */
        if ($entity && $entity->getState() !== $order->getWalleeTransaction()->getState()) {
            $cancel = false;
            switch ($entity->getState()) {
                case TransactionState::AUTHORIZED:
                case TransactionState::FULFILL:
                case TransactionState::COMPLETED:
                    $oldState = $order->getFieldData('oxtransstatus');
                    $order->setWalleeState($entity->getState());
                    if (!WalleeModule::isAuthorizedState($oldState)) {
                        $order->WalleeAuthorize();
                    }
                    return true;
                case TransactionState::CONFIRMED:
                case TransactionState::PROCESSING:
                	$order->setWalleeState($entity->getState());
                	return true;
                case TransactionState::VOIDED:
                    $cancel = true;
                case TransactionState::DECLINE:
                case TransactionState::FAILED:
                	$order->setWalleeState($entity->getState());
                	$order->WalleeFail($entity->getUserFailureMessage(), $entity->getState(), $cancel, true);
                	return true;
                default:
                	return false;
            }
        }
        return false;
    }
}