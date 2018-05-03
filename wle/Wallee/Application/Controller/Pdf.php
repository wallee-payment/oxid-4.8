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

namespace Wle\Wallee\Application\Controller;
require_once(OX_BASE_PATH . 'modules/wle/Wallee/autoload.php');


use Wallee\Sdk\Model\RenderedDocument;
use Wallee\Sdk\Service\TransactionService;
use Wle\Wallee\Core\WalleeModule;

/**
 * Class Webhook.
 */
class Pdf extends \oxview
{
    /**
     * @var \Wle\Wallee\Extend\Application\Model\Order
     */
    private $order;
    /**
     * @var TransactionService
     */
    private $service;

    /**
     * @throws \Exception
     */
    public function init()
    {
        parent::init();
        $orderId = WalleeModule::instance()->getRequestParameter('oxid');
class_exists('oxorder');        $order = oxNew('oxorder');
        /* @var $order \Wle\Wallee\Extend\Application\Model\Order */
        if (!$orderId || !$order->load($orderId)) {
            throw new \Exception("No order id supplied, or order could not be loaded: '$orderId'.");
        }
        if (!$order->isWleOrder()) {
            throw new \Exception("Given order is not a wallee order: '$orderId'.");
        }
        $this->order = $order;
        $this->service = new TransactionService(WalleeModule::instance()->getApiClient());
    }

    /**
     * @throws \Exception
     */
    private function verifyUser()
    {
        if ($this->getUser()->getId() !== $this->order->getOrderUser()->getId() && !$this->isAdmin()) {
            throw new \Exception("Attempting to download document from other user.");
        }
    }

    /**
     * @throws \Exception
     * @throws \Wallee\Sdk\ApiException
     */
    public function packingSlip()
    {
        if (!WalleeModule::settings()->isDownloadPackingEnabled()) {
            throw new \Exception("Packing slip download is not enabled.");
        }
        $this->verifyUser();

        $document = $this->service->getPackingSlip($this->order->getWalleeTransaction()->getSpaceId(), $this->order->getWalleeTransaction()->getTransactionId());

        $this->renderDocument($document);
    }

    /**
     * @throws \Exception
     * @throws \Wallee\Sdk\ApiException
     */
    public function invoice()
    {
        if (!WalleeModule::settings()->isDownloadInvoiceEnabled()) {
            throw new \Exception("Invoice download is not enabled.");
        }
        $this->verifyUser();

        $document = $this->service->getInvoiceDocument($this->order->getWalleeTransaction()->getSpaceId(), $this->order->getWalleeTransaction()->getTransactionId());

        $this->renderDocument($document);
    }

    /**
     * Outputs the given document.
     *
     * @param RenderedDocument $document
     */
    private function renderDocument(RenderedDocument $document)
    {
        header('Pragma: public');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Content-type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $document->getTitle() . '.pdf"');
        header('Content-Description: ' . $document->getTitle());
        echo base64_decode($document->getData());
        exit();
    }
}