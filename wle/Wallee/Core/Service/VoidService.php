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
use Wallee\Sdk\Model\TransactionState;
use Wallee\Sdk\Service\TransactionVoidService;
use Wle\Wallee\Application\Model\AbstractJob;
use Wle\Wallee\Application\Model\VoidJob;
use Wle\Wallee\Core\WalleeModule;

/**
 * Class VoidService
 */
class VoidService extends JobService
{
    private $service;

    protected function getService()
    {
        if ($this->service === null) {
            $this->service = new TransactionVoidService(WalleeModule::instance()->getApiClient());
        }
        return $this->service;
    }


    protected function getJobType()
    {
        return VoidJob::class;
    }

    public function getSupportedTransactionStates()
    {
        return array(
            TransactionState::AUTHORIZED
        );
    }

    protected function processSend(AbstractJob $job)
    {
        if (!$job instanceof VoidJob) {
            throw new \Exception("Invalid job type supplied.");
        }
        return $this->getService()->voidOnline($job->getSpaceId(), $job->getTransactionId());
    }

    public function resendAll()
    {
        $errors = array();
class_exists(VoidJob::class);        $void = oxNew(VoidJob::class);
        /* @var $void \Wle\Wallee\Application\Model\VoidJob */
        $notSent = $void->loadNotSentIds();
        foreach ($notSent as $job) {
            if ($void->loadByJob($job['WLEJOBID'], $job['WLESPACEID'])) {
                $this->send($void);
                if ($void->getState() === self::getFailedState()) {
                    $errors[] = $void->getFailureReason();
                }
            } else {
                WalleeModule::log(Logger::ERROR, "Unable to load pending job {$job['WLEJOBID']} / {$job['WLESPACEID']}.");
            }
        }
        return $errors;
    }
}