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
use Wallee\Sdk\Model\TransactionInvoiceState;
use Wallee\Sdk\Service\TransactionInvoiceService;
use Wle\Wallee\Core\WalleeModule;
use Wle\Wallee\Extend\Application\Model\Order;

/**
 * Webhook processor to handle manual task state transitions.
 */
class TransactionInvoice extends AbstractOrderRelated
{
    /**
     * Loads and returns the entity for the webhook request.
     * @param Request $request
     * @return \Wallee\Sdk\Model\TransactionInvoice
     * @throws \Wallee\Sdk\ApiException
     */
    protected function loadEntity(Request $request)
    {
        $service = new TransactionInvoiceService(WalleeModule::instance()->getApiClient());
        return $service->read($request->getSpaceId(), $request->getEntityId());
    }

    /**
     * Loads and returns the order id associated with the given entity.
     *
     * @param object $entity
     * @return string
     * @throws \Exception
     */
    protected function getOrderId($entity)
    {
        /* @var $entity \Wallee\Sdk\Model\TransactionInvoice */
class_exists(\Wle\Wallee\Application\Model\Transaction::class);        $transaction = oxNew(\Wle\Wallee\Application\Model\Transaction::class);
        /* @var $transaction \Wle\Wallee\Application\Model\Transaction */
        if ($transaction->loadByTransactionAndSpace($this->getTransactionId($entity), $entity->getLinkedSpaceId())) {
            return $transaction->getOrderId();
        }
        throw new \Exception("Could not load transaction {$entity->getLinkedTransaction()} in space {$entity->getLinkedSpaceId()}.");
    }

    /**
     * Returns the transaction id linked to the entity
     *
     *
     * @param object $entity
     * @return int
     */
    protected function getTransactionId($entity)
    {
        /* @var $entity \Wallee\Sdk\Model\TransactionInvoice */
        return $entity->getLinkedTransaction();
    }

    /**
     * Actually processes the order related webhook request.
     *
     * This must be implemented
     *
     * @param Order $order
     * @param object $entity
     */
    protected function processOrderRelatedInner(\oxorder $order, $entity)
    {
        /* @var $entity \Wallee\Sdk\Model\TransactionInvoice */
        switch ($entity->getState()) {
            case TransactionInvoiceState::NOT_APPLICABLE:
            case TransactionInvoiceState::PAID:
                $order->setWalleePaid();
                return true;
            default:
                WalleeModule::log(Logger::WARNING, "Received unprocessable TransactionInvoiceState {$entity->getState()}.");
                return false;
        }
    }
}