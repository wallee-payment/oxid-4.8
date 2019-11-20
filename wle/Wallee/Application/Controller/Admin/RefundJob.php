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

namespace Wle\Wallee\Application\Controller\Admin;
require_once(OX_BASE_PATH . 'modules/wle/Wallee/autoload.php');

use Monolog\Logger;
use Wle\Wallee\Core\Service\RefundService;
use Wle\Wallee\Core\WalleeModule;


/**
 * Class RefundJob.
 */
class RefundJob extends \oxadminview
{
    /**
     * Controller template name.
     *
     * @var string
     */
    protected $_sThisTemplate = 'wleWalleeRefundJob.tpl';

    /**
     * @return mixed|string
     */
    public function render()
    {
        $mReturn = $this->_RefundJob_render_parent();

class_exists(\Wle\Wallee\Application\Model\Transaction::class);        $transaction = oxNew(\Wle\Wallee\Application\Model\Transaction::class);
        /* @var $transaction \Wle\Wallee\Application\Model\Transaction */
        if ($transaction->loadByOrder($this->getEditObjectId())) {
            try {
                $transaction->pull();
                $this->_aViewData['lineItems'] = RefundService::instance()->getReducedItems($transaction);
                $this->_aViewData['oxTransactionId'] = $transaction->getId();
                return $mReturn;
            } catch (\Exception $e) {
                $error = WalleeModule::instance()->translate("Unable to load transaction for order !id.", true, array('!id' => $this->getEditObjectId()));
                $error .= ' ' . $e->getMessage() . ' - ' . $e->getTraceAsString();
            }
        } else {
            $error = WalleeModule::instance()->translate("Unable to load transaction for order !id.", true, array('!id' => $this->getEditObjectId()));
        }
        WalleeModule::log(Logger::ERROR, $error);
        $this->_aViewData['wle_error'] = $error;
        return 'wleWalleeError.tpl';
    }

    public function refund()
    {
    	WalleeModule::log(Logger::DEBUG, "Start refund.");
class_exists(\Wle\Wallee\Application\Model\Transaction::class);        $transaction = oxNew(\Wle\Wallee\Application\Model\Transaction::class);
        /* @var $transaction \Wle\Wallee\Application\Model\Transaction */
        try {
        	if ($transaction->loadByOrder($this->getEditObjectId())) {
        		WalleeModule::log(Logger::DEBUG, "Loaded by order.");
        		$transaction->pull();
        		$job = RefundService::instance()->create($transaction, false);
        		WalleeModule::log(Logger::DEBUG, "Created job.");
                $job->setFormReductions(WalleeModule::instance()->getRequestParameter('item'));
                $job->setRestock(WalleeModule::instance()->getRequestParameter('restock') !== null);
                $job->save();
                WalleeModule::log(Logger::DEBUG, "Saved job.");
                RefundService::instance()->send($job);
                WalleeModule::log(Logger::DEBUG, "Sent job.");
            } else {
                WalleeModule::log(Logger::ERROR, "Unable to load transaction for order {$this->getEditObjectId()}.");
            }
        } catch (\Exception $e) {
            $refundId = "";
            if (isset($job)) {
                $refundId = " (" . $job->getId() . ")";
            }
            $message = "Unable to process refund $refundId for transaction {$transaction->getTransactionId()}. {$e->getMessage()} - {$e->getTraceAsString()}.";
            WalleeModule::log(Logger::ERROR, $message);
            WalleeModule::getUtilsView()->addErrorToDisplay($message);
        }

        \oxregistry::getUtils()->redirect(WalleeModule::getUtilsUrl()->cleanUrlParams(WalleeModule::getUtilsUrl()->appendUrl(WalleeModule::getUtilsUrl()->getCurrentUrl(), array('cl' => 'wle_wallee_Transaction', 'oxid' => $transaction->getOrderId(), 'cur' => $transaction->getOrderId())), '&'));
    }

    /**
     * Parent `render` call.
     * Method required for mocking.
     *
     * @codeCoverageIgnore
     *
     * @return mixed
     */
    protected function _RefundJob_render_parent()
    {
        return parent::render();
    }
}