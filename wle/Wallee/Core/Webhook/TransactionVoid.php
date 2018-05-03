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

use Wallee\Sdk\Service\TransactionVoidService;
use Wle\Wallee\Application\Model\VoidJob;
use Wle\Wallee\Core\WalleeModule;
use Wle\Wallee\Extend\Application\Model\Order;
use Wallee\Sdk\Model\TransactionVoidState;
use Monolog\Logger;

/**
 * Webhook processor to handle transaction void state transitions.
 */
class TransactionVoid extends AbstractOrderRelated
{

    /**
     * @param Request $request
     * @return \Wallee\Sdk\Model\TransactionVoid
     * @throws \Wallee\Sdk\ApiException
     */
    protected function loadEntity(Request $request)
    {
        $voidService = new TransactionVoidService(WalleeModule::instance()->getApiClient());
        return $voidService->read($request->getSpaceId(), $request->getEntityId());
    }

    protected function getOrderId($void)
    {
        /* @var \Wallee\Sdk\Model\TransactionVoid $void */
class_exists(\Wle\Wallee\Application\Model\Transaction::class);        $transaction = oxNew(\Wle\Wallee\Application\Model\Transaction::class);
        /* @var $dbTransaction \Wle\Wallee\Application\Model\Transaction */
        $transaction->loadByTransactionAndSpace($void->getTransaction()->getId(), $void->getLinkedSpaceId());
        return $transaction->getOrderId();
    }

    protected function getTransactionId($entity)
    {
        /* @var $entity \Wallee\Sdk\Model\TransactionVoid */
        return $entity->getTransaction()->getId();
    }

    protected function processOrderRelatedInner(\oxorder $order, $void)
    {
        /* @var \Wallee\Sdk\Model\TransactionVoid $void */
        if ($this->apply($void, $order)) {
            switch ($void->getState()) {
                case TransactionVoidState::SUCCESSFUL:
                    $order->cancelOrder();
                    return true;
                default:
                    // Nothing to do.
                    break;
            }
        }
        return false;
    }

    protected function apply(\Wallee\Sdk\Model\TransactionVoid $void, Order $order)
    {
class_exists(\Wle\Wallee\Application\Model\VoidJob::class);    	$job = oxNew(\Wle\Wallee\Application\Model\VoidJob::class);
        /* @var $job \Wle\Wallee\Application\Model\VoidJob */
        if ($job->loadByJob($void->getId(), $void->getLinkedSpaceId()) || $job->loadByOrder($order->getId())) {
            if ($job->getState() !== $void->getState()) {
                $job->apply($void);
                return true;
            }
        } else {
            WalleeModule::log(Logger::WARNING, "Unknown void received, was not processed: $void.");
        }
        return false;
    }
}