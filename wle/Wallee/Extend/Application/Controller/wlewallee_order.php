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



use Monolog\Logger;
use Wallee\Sdk\Model\TransactionState;
use Wle\Wallee\Application\Model\Transaction;
use Wle\Wallee\Core\Service\TransactionService;
use Wle\Wallee\Core\WalleeModule;

/**
 * Class BasketItem.
 * Extends \order.
 *
 * @mixin \order
 */
class wlewallee_order extends wlewallee_order_parent
{
    public function init()
    {
        $this->_OrderController_init_parent();
        if ($this->getIsOrderStep()) {
            try {
                $transaction = Transaction::loadPendingFromSession($this->getSession());
                $transaction->updateFromSession();
            } catch (\Exception $e) {
                WalleeModule::log(Logger::ERROR, "Could not update transaction: {$e->getMessage()}.");
            }
        }
    }

    protected function _OrderController_init_parent()
    {
        parent::init();
    }

    public function wleConfirm()
    {
class_exists('oxorder');    	$order = oxNew('oxorder');
        $response = array(
            'status' => false,
            'message' => 'unkown'
        );

        if ($this->isWalleeTransaction()) {
            try {
                $transaction = Transaction::loadPendingFromSession($this->getSession());
                /* @var $order \Wle\Wallee\Extend\Application\Model\Order */
                /** @noinspection PhpParamsInspection */
                $state = $order->finalizeOrder($this->getBasket(), $this->getUser());
                if ($state === 'WALLEE_' . TransactionState::PENDING) {
                    $transaction->setTempBasket($this->getBasket());
                    $transaction->setOrderId($order->getId());
                    $transaction->updateFromSession(true);
                    $response['status'] = true;
                } else if ($state == \oxorder::ORDER_STATE_ORDEREXISTS) {
                    // ensure new order can be created
                    $this->getSession()->deleteVariable('sess_challenge');
                    throw new \Exception(WalleeModule::instance()->translate("Order already exists. Please check if you have already received a confirmation, then try again."));
                } else {
                    throw new \Exception(WalleeModule::instance()->translate("Unable to confirm order in state !state.", true, array('!state' => $state)));
                }
            } catch (\Exception $e) {
                if (isset($transaction)) {
                    $state = $transaction->getState();
                } else if (!isset($state)) {
                    $state = 'confirmation_error_unkown';
                }
                $order->WalleeFail($e->getMessage(), $state, true);
                WalleeModule::log(Logger::ERROR, "Unable to confirm transaction: {$e->getMessage()}.");
                $response['message'] = $e->getMessage();
            }
        } else {
            $response['message'] = WalleeModule::instance()->translate("Not a WhiteLabenName order.");
        }

        WalleeModule::renderJson($response);
    }

    public function wleError()
    {
        try {
            $orderId = WalleeModule::instance()->getRequestParameter('oxid');
            if ($orderId) {
class_exists('oxorder');            	$order = oxNew('oxorder');
                /* @var $order Order */
class_exists(\Wle\Wallee\Application\Model\Transaction::class);            	$transaction = oxNew(\Wle\Wallee\Application\Model\Transaction::class);
                /* @var $transaction Transaction */
                if ($order->load($orderId) && $transaction->loadByOrder($orderId)) {
                    $transaction->pull();
                    $order->WalleeFail($transaction->getSdkTransaction()->getUserFailureMessage(), $transaction->getState());
                    WalleeModule::getUtilsView()->addErrorToDisplay($transaction->getSdkTransaction()->getUserFailureMessage());
                } else {
                	WalleeModule::getUtilsView()->addErrorToDisplay(WalleeModule::instance()->translate("An unknown error occurred, and the order could not be loaded."));
                }
            } else {
                $transaction = Transaction::loadFailedFromSession($this->getSession());
                if ($transaction) {
                    if ($transaction->getOrderId()) {
class_exists('oxorder');                    	$order = oxNew('oxorder');
                        /* @var $order \oxorder */
                        if ($order->load($transaction->getOrderId())) {
                            $order->WalleeFail($transaction->getSdkTransaction()->getUserFailureMessage(), $transaction->getState());
                        }
                    }
                    WalleeModule::getUtilsView()->addErrorToDisplay($transaction->getSdkTransaction()->getUserFailureMessage());
                } else {
                	WalleeModule::getUtilsView()->addErrorToDisplay(WalleeModule::instance()->translate("An unknown error occurred, and the order could not be loaded."));
                }
            }
        } catch (\Exception $e) {
        	WalleeModule::getUtilsView()->addErrorToDisplay($e);
        }
    }
    
    public function isWalleeTransaction()
    {
        return WalleeModule::isWalleePayment($this->getBasket()->getPaymentId());
    }

    public function getWalleePaymentId()
    {
        return WalleeModule::extractWalleeId($this->getBasket()->getPaymentId());
    }

    public function getWalleeJavascriptUrl()
    {
        try {
            $transaction = Transaction::loadPendingFromSession($this->getSession());
            return TransactionService::instance()->getJavascriptUrl($transaction->getTransactionId(), $transaction->getSpaceId());
        } catch (\Exception $e) {
            WalleeModule::log(Logger::ERROR, $e->getMessage(), array($this, $e));
        }
        return '';
    }
}