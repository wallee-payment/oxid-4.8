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


namespace Wle\Wallee\Application\Model;
require_once(OX_BASE_PATH . 'modules/wle/Wallee/autoload.php');

;
use Wallee\Sdk\Model\Refund;
use Wallee\Sdk\Model\TransactionCompletion;
use Wallee\Sdk\Model\TransactionVoid;
use Wle\Wallee\Core\Service\JobService;
use Wle\Wallee\Core\WalleeModule;

/**
 * Class AbstractJob.
 */
abstract class AbstractJob extends \oxbase
{
	protected $_aSkipSaveFields = ['oxtimestamp', 'WLEUPDATED'];
    private $sdkObject;

    /**
     * @return mixed
     */
    public function getSdkObject()
    {
        return $this->sdkObject;
    }

    /**
     * @param mixed $sdkObject
     */
    public function setSdkObject($sdkObject)
    {
        $this->sdkObject = $sdkObject;
    }


    public function setJobId($value)
    {
        $this->_setFieldData('wlejobid', $value);
    }

    public function getJobId()
    {
        return $this->getFieldData('wlejobid');
    }

    public function setTransactionId($value)
    {
        $this->_setFieldData('wletransactionid', $value);
    }

    public function getTransactionId()
    {
        return $this->getFieldData('wletransactionid');
    }

    public function setState($value)
    {
        $this->_setFieldData('wlestate', $value);
    }

    public function getState()
    {
        return $this->getFieldData('wlestate');
    }

    public function setSpaceId($value)
    {
        $this->_setFieldData('wlespaceid', $value);
    }

    public function getSpaceId()
    {
        return $this->getFieldData('wlespaceid');
    }

    public function setOrderId($value)
    {
        $this->_setFieldData('oxorderid', $value);
    }

    public function getOrderId()
    {
        return $this->getFieldData('oxorderid');
    }

    public function setFailureReason($value)
    {
        $this->_setFieldData('wlefailurereason', base64_encode(serialize($value)));
    }

    public function getFailureReason()
    {
        $value = unserialize(base64_decode($this->getFieldData('wlefailurereason')));
        if (is_array($value)) {
            $value = WalleeModule::instance()->WalleeTranslate($value);
        }
        return $value;
    }

    public function loadByOrder($orderId, $targetStates = array())
    {
        $this->_addField('oxid', 0);
        $query = $this->buildSelectString(['oxorderid' => $orderId]);
        if (!empty($targetStates)) {
            $query .= " AND `wlestate` in ('" . implode("', '", $targetStates) . "')";
        }
        $this->_isLoaded = $this->assignRecord($query);
        return $this->_isLoaded;
    }

    public function loadByJob($jobId, $spaceId)
    {
        $this->_addField('oxid', 0);
        $query = $this->buildSelectString(['wlejobid' => $jobId, 'wlespaceid' => $spaceId]);
        $this->_isLoaded = $this->assignRecord($query);
        return $this->_isLoaded;
    }

    /**
     * @throws \Exception
     */
    public function pull()
    {
        $this->apply($this->getService()->read($this));
    }

    /**
     * @return JobService
     */
    protected abstract function getService();

    /**
     * @param TransactionVoid|TransactionCompletion|Refund $job
     * @throws \Exception
     */
    public function apply($job)
    {
        $this->setJobId($job->getId());
        $this->setSpaceId($job->getLinkedSpaceId());

        // getState not in TransactionAwareEntity
        if ($job instanceof TransactionCompletion || $job instanceof TransactionVoid || $job instanceof Refund) {
            $this->setState($job->getState());
        }
        if ($job instanceof Refund) {
            $this->setTransactionId($job->getTransaction()->getId());
        } else {
            $this->setTransactionId($job->getLinkedTransaction());
        }
        $this->setSdkObject($job);
        $this->_isLoaded = true;
        $this->save();
    }

    protected function createNotSentQuery() {
        $table = $this->getCoreTableName();
        $createState = JobService::getCreationState();
        return "SELECT `WLEJOBID`, `WLESPACEID` FROM `$table` WHERE `WLESTATE` = '$createState';";
    }

    public function loadNotSentIds()
    {
        return \oxdb::getDb()->select($this->createNotSentQuery());
    }
}