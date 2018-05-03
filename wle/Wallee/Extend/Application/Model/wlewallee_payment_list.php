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




use Wle\Wallee\Application\Model\Transaction;
use Wle\Wallee\Core\Service\PaymentService;
use Wle\Wallee\Core\WalleeModule;
use Monolog\Logger;

/**
 * Class PaymentList.
 * Extends \oxpaymentlist.
 *
 * @mixin \oxpaymentlist
 */
class wlewallee_payment_list extends wlewallee_payment_list_parent
{

    /**
     * Loads all Wallee payment methods.
     */
    public function loadWalleePayments()
    {
        $prefix = WalleeModule::PAYMENT_PREFIX;
        $this->selectString("SELECT * FROM `oxpayments` WHERE `oxid` LIKE '$prefix%'");
        return $this->_aArray;
    }

    /**
     * Loads all Wallee payment methods.
     */
    public function loadActiveWalleePayments()
    {
        $prefix = WalleeModule::PAYMENT_PREFIX;
        $this->selectString("SELECT * FROM `oxpayments` WHERE `oxid` LIKE '$prefix%' AND `oxactive` = '1'");
        return $this->_aArray;
    }

    public function getPaymentList($sShipSetId, $dPrice, $oUser = null)
    {
        $oxPayments = $this->_PaymentList_getPaymentList_parent($sShipSetId, $dPrice, $oUser);
        if(!$this->isAdmin()) {
            $this->clear();
            $WalleePayments = array();
            try {
                $transaction = Transaction::loadPendingFromSession($this->getSession());
                $WalleePayments = PaymentService::instance()->fetchAvailablePaymentMethods($transaction->getTransactionId(), $transaction->getSpaceId());
            } catch (\Exception $e) {
                WalleeModule::log(Logger::ERROR, $e->getMessage(), array($this, $e));
            }
            foreach ($oxPayments as $oxPayment) {
                /* @var $oxPayment \oxpayment */
                if (WalleeModule::isWalleePayment($oxPayment->getId())) {
                    if (in_array($oxPayment->getId(), $WalleePayments)) {
                        $this->_aArray[$oxPayment->getId()] = $oxPayment;
                    }
                } else {
                    $this->_aArray[$oxPayment->getId()] = $oxPayment;
                }
            }
        }
        return $this->_aArray;
    }

    protected function _PaymentList_getPaymentList_parent($sShipSetId, $dPrice, $oUser = null)
    {
        return parent::getPaymentList($sShipSetId, $dPrice, $oUser);
    }
}