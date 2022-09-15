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
use Wallee\Sdk\Model\RefundState;
use Wallee\Sdk\Model\TransactionCompletionState;
use Wallee\Sdk\Model\TransactionVoidState;
use Wle\Wallee\Core\Exception\OptimisticLockingException;
use Wle\Wallee\Core\Service\CompletionService;
use Wle\Wallee\Core\Service\RefundService;
use Wle\Wallee\Core\Service\VoidService;
use Wle\Wallee\Core\WalleeModule;


/**
 * Class Transaction.
 */
class Transaction extends \oxadmindetails
{

    /**
     * Controller template name.
     *
     * @var string
     */
    protected $_sThisTemplate = 'wleWalleeTransaction.tpl';

    /**
     * @return string
     */
    public function render()
    {
        parent::render();
        $this->_aViewData['wle_wallee_enabled'] = false;
        $orderId = $this->getEditObjectId();
        try {
            if ($orderId != '-1' && isset($orderId)) {
class_exists(\Wle\Wallee\Application\Model\Transaction::class);                $transaction = oxNew(\Wle\Wallee\Application\Model\Transaction::class);
                /* @var $transaction \Wle\Wallee\Application\Model\Transaction */
                if ($transaction->loadByOrder($orderId)) {
                    $transaction->pull();
                    $this->_aViewData['labelGroupings'] = $transaction->getLabels();
                    $this->_aViewData['wle_wallee_enabled'] = true;
                    return $this->_sThisTemplate;
                } else {
                    throw new \Exception(WalleeModule::instance()->translate('Not a wallee order.'));
                }
            } else {
                throw new \Exception(WalleeModule::instance()->translate('No order selected'));
            }
        } catch (OptimisticLockingException $e) {
            $this->_aViewData['wle_wallee_enabled'] = $e->getMessage();
            return $this->_sThisTemplate;
        } catch (\Exception $e) {
            $this->_aViewData['wle_error'] = $e->getMessage();
            return 'wleWalleeError.tpl';
        }
    }

    /**
     * Creates and sends a completion job.
     */
    public function complete()
    {
    	WalleeModule::log(Logger::DEBUG, "Start complete.");
        $oxid = $this->getEditObjectId();
class_exists(\Wle\Wallee\Application\Model\Transaction::class);        $transaction = oxNew(\Wle\Wallee\Application\Model\Transaction::class);
        /* @var $transaction \Wle\Wallee\Application\Model\Transaction */
        if ($transaction->loadByOrder($oxid)) {
        	WalleeModule::log(Logger::DEBUG, "Loaded by order.");
            try {
            	$transaction->updateLineItems();
            	WalleeModule::log(Logger::DEBUG, "Updated items.");
            	$job = CompletionService::instance()->create($transaction);
            	WalleeModule::log(Logger::DEBUG, "Created job.");
            	CompletionService::instance()->send($job);
            	WalleeModule::log(Logger::DEBUG, "Sent job.");
                if ($job->getState() === TransactionCompletionState::FAILED) {
                	WalleeModule::getUtilsView()->addErrorToDisplay($job->getFailureReason());
                } else {
                    $this->_aViewData['message'] = WalleeModule::instance()->translate("Successfully created and sent completion job !id.", true, array('!id' => $job->getJobId()));
                }
            } catch (\Exception $e) {
                WalleeModule::log(Logger::ERROR, "Exception occurred while completing transaction: {$e->getMessage()} - {$e->getTraceAsString()}");
                WalleeModule::getUtilsView()->addErrorToDisplay($e->getMessage()); // To set error
            }
        } else {
            $error = "Unable to load transaction by order $oxid for completion.";
            WalleeModule::log(Logger::ERROR, $error);
            WalleeModule::getUtilsView()->addErrorToDisplay($error); // To set error
        }
    }

    /**
     * Creates and sends a void job.
     *
     */
    public function void()
    {
    	WalleeModule::log(Logger::DEBUG, "Start void.");
        $oxid = $this->getEditObjectId();
class_exists(\Wle\Wallee\Application\Model\Transaction::class);        $transaction = oxNew(\Wle\Wallee\Application\Model\Transaction::class);
        /* @var $transaction \Wle\Wallee\Application\Model\Transaction */
        if ($transaction->loadByOrder($oxid)) {
        	WalleeModule::log(Logger::DEBUG, "Loaded by order.");
        	try {
        		$transaction->pull();
        		$job = VoidService::instance()->create($transaction);
        		WalleeModule::log(Logger::DEBUG, "Created job.");
        		VoidService::instance()->send($job);
        		WalleeModule::log(Logger::DEBUG, "Sent job.");
                if ($job->getState() === TransactionVoidState::FAILED) {
                	WalleeModule::getUtilsView()->addErrorToDisplay($job->getFailureReason());
                } else {
                    $this->_aViewData['message'] = WalleeModule::instance()->translate("Successfully created and sent void job !id.", true, array('!id' => $job->getJobId()));
                }
            } catch (\Exception $e) {
                WalleeModule::log(Logger::ERROR, "Exception occurred while completing transaction: {$e->getMessage()} - {$e->getTraceAsString()}");
                WalleeModule::getUtilsView()->addErrorToDisplay($e->getMessage()); // To set error
            }
        } else {
            $error = "Unable to load transaction by order $oxid for completion.";
            WalleeModule::log(Logger::ERROR, $error);
            WalleeModule::getUtilsView()->addErrorToDisplay($error); // To set error
        }
    }

    /**
     * Checks if the transaction associated with the given order id is in the correct state for completion, and checks if any completion jobs are currently running.
     *
     * @param $orderId
     * @return bool
     */
    public function canComplete($orderId)
    {
        try {
class_exists(\Wle\Wallee\Application\Model\CompletionJob::class);        	$job = oxNew(\Wle\Wallee\Application\Model\CompletionJob::class);
            /* @var $job \Wle\Wallee\Application\Model\CompletionJob */
class_exists(\Wle\Wallee\Application\Model\Transaction::class);            $transaction = oxNew(\Wle\Wallee\Application\Model\Transaction::class);
            /* @var $transaction \Wle\Wallee\Application\Model\Transaction */
            $transaction->loadByOrder($orderId);
            $transaction->pull();
            return !$job->loadByOrder($orderId, array(TransactionCompletionState::PENDING)) &&
                in_array($transaction->getState(), CompletionService::instance()->getSupportedTransactionStates());
        } catch (\Exception $e) {
            WalleeModule::log(Logger::ERROR, "Unable to check completion possibility: {$e->getMessage()} - {$e->getTraceAsString()}");
        }
        return false;
    }

    /**
     * Checks if the transaction associated with the given order id is in the correct state for refund, and checks if any refund jobs are currently running.
     *
     * @param $orderId
     * @return bool
     */
    public function canRefund($orderId)
    {
        try {
class_exists(\Wle\Wallee\Application\Model\RefundJob::class);            $job = oxNew(\Wle\Wallee\Application\Model\RefundJob::class);
            /* @var $job \Wle\Wallee\Application\Model\RefundJob */
class_exists(\Wle\Wallee\Application\Model\Transaction::class);            $transaction = oxNew(\Wle\Wallee\Application\Model\Transaction::class);
            /* @var $transaction \Wle\Wallee\Application\Model\Transaction */
            $transaction->loadByOrder($orderId);
            $transaction->pull();
            return !$job->loadByOrder($orderId, array(RefundState::MANUAL_CHECK, RefundState::PENDING)) &&
                in_array($transaction->getState(), RefundService::instance()->getSupportedTransactionStates()) && !empty(RefundService::instance()->getReducedItems($transaction));
        } catch (\Exception $e) {
            WalleeModule::log(Logger::ERROR, "Unable to check completion possibility: {$e->getMessage()} - {$e->getTraceAsString()}");
        }
        return false;
    }

    /**
     * Checks if the transaction associated with the given order id is in the correct state for void, and checks if any void jobs are currently running.
     * @param $orderId
     * @return bool
     */
    public function canVoid($orderId)
    {
        try {
class_exists(\Wle\Wallee\Application\Model\VoidJob::class);        	$job = oxNew(\Wle\Wallee\Application\Model\VoidJob::class);
            /* @var $job \Wle\Wallee\Application\Model\VoidJob */
class_exists(\Wle\Wallee\Application\Model\Transaction::class);            $transaction = oxNew(\Wle\Wallee\Application\Model\Transaction::class);
            /* @var $transaction \Wle\Wallee\Application\Model\Transaction */
            $transaction->loadByOrder($orderId);
            $transaction->pull();
            return !$job->loadByOrder($orderId, array(TransactionVoidState::PENDING)) &&
                in_array($transaction->getState(), VoidService::instance()->getSupportedTransactionStates());
        } catch (\Exception $e) {
            WalleeModule::log(Logger::ERROR, "Unable to check void possibility: {$e->getMessage()} - {$e->getTraceAsString()}");
        }
        return false;
    }
}