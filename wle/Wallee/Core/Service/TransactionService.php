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


namespace Wle\Wallee\Core\Service;
require_once(OX_BASE_PATH . 'modules/wle/Wallee/autoload.php');

use Monolog\Logger;
use Wallee\Sdk\Model\EntityQuery;
use Wallee\Sdk\Model\TransactionCreate;
use Wallee\Sdk\Model\TransactionLineItemUpdateRequest;
use Wallee\Sdk\Model\TransactionPending;
use Wallee\Sdk\Service\TransactionInvoiceService;
use Wle\Wallee\Core\WalleeModule;
use \Wallee\Sdk\Service\TransactionService as SdkTransactionService;

/**
 * Class TransactionService
 * Handles api interactions regarding transaction.
 *
 * @codeCoverageIgnore
 */
class TransactionService extends AbstractService
{
    private $service;
    private $invoiceService;

    protected function getService()
    {
        if (!$this->service) {
            $this->service = new SdkTransactionService(WalleeModule::instance()->getApiClient());
        }
        return $this->service;
    }

    /**
     * @return TransactionInvoiceService
     */
    protected function getInvoiceService()
    {
        if (!$this->invoiceService) {
            $this->invoiceService = new TransactionInvoiceService(WalleeModule::instance()->getApiClient());
        }
        return $this->invoiceService;

    }

    /**
     * Reads a transaction entity from Wallee
     *
     * @param $transactionId
     * @param $spaceId
     * @return \Wallee\Sdk\Model\Transaction
     * @throws \Wallee\Sdk\ApiException
     */
    public function read($transactionId, $spaceId)
    {
        return $this->getService()->read($spaceId, $transactionId);
    }

    /**
     *
     * @param TransactionCreate $transaction
     * @return \Wallee\Sdk\Model\Transaction
     * @throws \Wallee\Sdk\ApiException
     */
    public function create(TransactionCreate $transaction)
    {
        return $this->getService()->create(WalleeModule::settings()->getSpaceId(), $transaction);
    }

    /**
     * @param $transactionId
     * @param $spaceId
     * @return \Wallee\Sdk\Model\TransactionInvoice
     * @throws \Exception
     * @throws \Wallee\Sdk\ApiException
     */
    public function getInvoice($transactionId, $spaceId)
    {
        $query = new EntityQuery();
        $query->setFilter($this->createEntityFilter('completion.lineItemVersion.transaction.id', $transactionId));
        $query->setNumberOfEntities(1);
        $invoices = $this->getInvoiceService()->search($spaceId, $query);
        if (empty($invoices)) {
            throw new \Exception("No transaction invoice found for transaction $transactionId / $spaceId.");
        }
        return $invoices[0];
    }

    /**
     * @param TransactionPending $transaction
     * @param bool $confirm
     * @return \Wallee\Sdk\Model\Transaction
     * @throws \Wallee\Sdk\ApiException
     */
    public function update(TransactionPending $transaction, $confirm = false)
    {
        if ($confirm) {
            return $this->getService()->confirm(WalleeModule::settings()->getSpaceId(), $transaction);
        } else {
            return $this->getService()->update(WalleeModule::settings()->getSpaceId(), $transaction);
        }
    }

    public function updateLineItems($spaceId, TransactionLineItemUpdateRequest $updateRequest) {
        return $this->getService()->updateTransactionLineItems($spaceId, $updateRequest);
    }

    /**
     * @param $transactionId
     * @param $spaceId
     * @return string
     * @throws \Wallee\Sdk\ApiException
     */
    public function getJavascriptUrl($transactionId, $spaceId)
    {
        return $this->getService()->buildJavaScriptUrl($spaceId, $transactionId);
    }
}