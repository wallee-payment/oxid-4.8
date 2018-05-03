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



use \Wallee\Sdk\Model\TransactionState;
use \Wle\Wallee\Application\Model\Transaction;
use \Wle\Wallee\Core\WalleeModule;
use Monolog\Logger;

/**
 * Class Order.
 * Extends \oxorder.
 *
 * @mixin \oxorder
 */
class wlewallee_oxorder extends wlewallee_oxorder_parent
{
	private static $wleStateOrder = [
		TransactionState::CREATE => 0,
		TransactionState::PENDING => 1,
		TransactionState::CONFIRMED => 2,
		TransactionState::PROCESSING => 3,
		TransactionState::AUTHORIZED => 4,
		TransactionState::COMPLETED => 5,
		TransactionState::FULFILL => 6,
		TransactionState::DECLINE => 6,
		TransactionState::VOIDED => 6,
		TransactionState::FAILED => 6,
	];
	
    public function getWalleeBasket() {
        // copied from recalculateOrder, minus call of finalizeOrder, and adding new articles.
        $oBasket = $this->_getOrderBasket();
        /* @noinspection PhpParamsInspection */
        $this->_addOrderArticlesToBasket($oBasket, $this->getOrderArticles(true));
        $oBasket->calculateBasket(true);
        return $oBasket;
    }

    /**
     * Sets the oxtransstatus and oxfolder according to the given TransactionState
     *
     * @param string $state TransactionState enum
     */
    public function setWalleeState($state)
    {
        if (!$this->isWleOrder()) {
            WalleeModule::log(Logger::WARNING, "Attempted to call " . __METHOD__ . " on non-Wallee order {$this->getId()}, skipping.");
            return;
        }
        $oldState = substr($this->getFieldData('OXTRANSSTATUS'), strlen('WALLEE_'));
        if(self::$wleStateOrder[$oldState] > self::$wleStateOrder[$state]) {
        	throw new \Exception("Cannot move order from state $oldState to $state.");
        }
        $this->_setFieldData('OXTRANSSTATUS', 'WALLEE_' . $state);
        $this->_setFieldData('OXFOLDER', WalleeModule::getMappedFolder($state));
    }

    /**
     * Sends the confirmation email.
     *
     * @throws \Exception
     */
    public function WalleeAuthorize()
    {
        if (!$this->isWleOrder()) {
            WalleeModule::log(Logger::WARNING, "Attempted to call " . __METHOD__ . " on non-Wallee order {$this->getId()}, skipping.");
            return;
        }
        $basket = $this->getWalleeTransaction()->getTempBasket();
        $basket->onUpdate();
        $basket->calculateBasket();
        $res = $this->_sendOrderByEmail($this->getOrderUser(), $basket, $this->getPaymentType());
        if ($res === self::ORDER_STATE_OK) {
            $this->getWalleeTransaction()->setTempBasket(null);
            $this->getWalleeTransaction()->save();
        }
    }

    public function setWalleePaid()
    {
        if (!$this->isWleOrder()) {
            WalleeModule::log(Logger::WARNING, "Attempted to call " . __METHOD__ . " on non-Wallee order {$this->getId()}, skipping.");
            return;
        }
        $this->_setFieldData('oxpaid', date('Y-m-d H:i:s'), \oxfield::T_RAW);
    }

    /**
    * Sets the order state to the given state, and saves the message on the associated transaction.
    *
    * @param $message
    * @param $state
    * @param bool $cancel If the order should be cancelled
    * @param bool $rethrow if exceptions should be thrown.
    */
    public function WalleeFail($message, $state, $cancel = false, $rethrow = false)
    {
    	if (!$this->isWleOrder()) {
    		WalleeModule::log(Logger::WARNING, "Attempted to call " . __METHOD__ . " on non-Wallee order {$this->getId()}, skipping.");
    		return;
    	}
class_exists(\Wle\Wallee\Application\Model\Transaction::class);    	$transaction = oxNew(\Wle\Wallee\Application\Model\Transaction::class);
    	/* @var $transaction Transaction */
    	if ($transaction->loadByOrder($this->getId())) {
    		try {
    			$transaction->setFailureReason($message);
    			$transaction->save();
    		} catch (\Exception $e) {
    			// treat optimisticlockingexception equally.
    			WalleeModule::log(Logger::ERROR, "Unable to save transaction with ID {$transaction->getId()}: {$e->getMessage()}.");
    			if($rethrow) {
    				throw $e;
    			}
    		}
    	} else {
    		WalleeModule::log(Logger::ERROR, "Unable to save failure message '{$message}' on transaction for order {$this->getId()}.");
    	}
    	$this->getSession()->deleteVariable("sess_challenge"); // allow new orders
    	try {
    		$this->setWalleeState($state);
    		if ($cancel) {
    			$this->cancelOrder();
    		}
    	} catch (\Exception $e) {
    		WalleeModule::log(Logger::ERROR, "Unable to cancel order: {$e->getMessage()}.");
    		if($rethrow) {
    			throw $e;
    		}
    	}
    }
    
    public function getWalleeDownloads()
    {
        $downloads = array();
        if ($this->isWleOrder()) {
            $transaction = $this->getWalleeTransaction();
            if ($transaction && in_array($transaction->getState(), array(TransactionState::COMPLETED, TransactionState::FULFILL, TransactionState::DECLINE))) {
                if (WalleeModule::settings()->isDownloadInvoiceEnabled()) {
                    $downloads[] = array(
                        'link' => WalleeModule::getControllerUrl('wle_wallee_Pdf', 'invoice', $this->getId()),
                    	'text' => WalleeModule::instance()->translate('Download Invoice')
                    );
                }
                if (WalleeModule::settings()->isDownloadPackingEnabled()) {
                    $downloads[] = array(
                        'link' => WalleeModule::getControllerUrl('wle_wallee_Pdf', 'packingSlip', $this->getId()),
                    	'text' => WalleeModule::instance()->translate('Download Packing Slip')
                    );
                }

            }
        }
        return $downloads;
    }

    public function finalizeOrder(\oxbasket $oBasket, $oUser, $blRecalculatingOrder = false)
    {
        if (!$this->isWleOrder($oBasket)) {
            return $this->_Order_finalizeOrder_parent($oBasket, $oUser, $blRecalculatingOrder);
        }

        if ($this->getFieldData('oxtransstatus') === 'WALLEE_' . TransactionState::PENDING) {
            // suppress duplicate finalize
            return self::ORDER_STATE_OK;
        }

        $result = $this->_Order_finalizeOrder_parent($oBasket, $oUser, $blRecalculatingOrder);

        if ($result == self::ORDER_STATE_OK && !$blRecalculatingOrder) {
            $result = 'WALLEE_' . TransactionState::PENDING;
            $this->_setOrderStatus($result);
        }

        return $result;
    }

    protected function _Order_finalizeOrder_parent(\oxbasket $oBasket, $oUser, $blRecalculatingOrder = false)
    {
        return parent::finalizeOrder($oBasket, $oUser, $blRecalculatingOrder);
    }

    protected function _sendOrderByEmail($oUser = null, $oBasket = null, $oPayment = null)
    {
        if ($this->isWleOrder() && (!WalleeModule::isAuthorizedState($this->getFieldData('oxtransstatus')) || !WalleeModule::settings()->isEmailConfirmationActive())) {
            return self::ORDER_STATE_OK;
        }

        return $this->_Order_sendOrderByEmail_parent($oUser, $oBasket, $oPayment);
    }

    protected function _sendOrderByEmailForced($oUser = null, $oBasket = null, $oPayment = null)
    {
class_exists(\oxbasketItem::class);    	$basketItem = oxNew(\oxbasketItem::class);
        /* @var $basketItem \Wle\Wallee\Extend\Application\Model\BasketItem */
        $basketItem->wleDisableCheckProduct(true);

        $result = $this->_sendOrderByEmail($oUser, $oBasket, $oPayment);

        $basketItem->wleDisableCheckProduct(false);

        return $result;
    }

    protected function _Order_sendOrderByEmail_parent($oUser = null, $oBasket = null, $oPayment = null)
    {
        return parent::_sendOrderByEmail($oUser, $oBasket, $oPayment);
    }

    public function isWleOrder($basket = null)
    {
        $paymentType = $this->getFieldData('oxpaymenttype');
        if (empty($paymentType)) {
            if ($this->getBasket()) {
                $paymentType = $this->getBasket()->getPaymentId();
            } else if ($basket instanceof \oxbasket) { // TODO as is in 4.10 base, directly use oxBasket? Or use controller pattern?
                $paymentType = $basket->getPaymentId();
            }
        }
        return substr($paymentType, 0, strlen(WalleeModule::PAYMENT_PREFIX)) === WalleeModule::PAYMENT_PREFIX;
    }

    public function getWalleeTransaction()
    {
        if ($this->getId()) {
class_exists(\Wle\Wallee\Application\Model\Transaction::class);        	$transaction = oxNew(\Wle\Wallee\Application\Model\Transaction::class);
            /* @var $transaction Transaction */
            if ($transaction->loadByOrder($this->getId())) {
                return $transaction;
            }
        }
        return null;
    }
}