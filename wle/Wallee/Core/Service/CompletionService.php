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
use Wallee\Sdk\Service\TransactionCompletionService;
use Wle\Wallee\Application\Model\AbstractJob;
use Wle\Wallee\Application\Model\CompletionJob;
use Wle\Wallee\Application\Model\Transaction;
use Wle\Wallee\Core\WalleeModule;

/**
 * Class CompletionService
 */
class CompletionService extends JobService
{

    private $service;

    protected function getService()
    {
        if ($this->service === null) {
            $this->service = new TransactionCompletionService(WalleeModule::instance()->getApiClient());
        }
        return $this->service;
    }


    protected function getJobType()
    {
        return CompletionJob::class;
    }

    public function getSupportedTransactionStates()
    {
        return array(
            TransactionState::AUTHORIZED
        );
    }

    protected function processSend(AbstractJob $job)
    {
        if (!$job instanceof CompletionJob) {
            throw new \Exception("Invalid job type supplied.");
        }
        return $this->getService()->completeOnline($job->getSpaceId(), $job->getTransactionId());
    }

    public function resendAll()
    {
        $errors = array();
class_exists(CompletionJob::class);        $completion = oxNew(CompletionJob::class);
        /* @var $completion \Wle\Wallee\Application\Model\CompletionJob */
        $notSent = $completion->loadNotSentIds();
        foreach ($notSent as $job) {
            if ($completion->loadByJob($job['WLEJOBID'], $job['WLESPACEID'])) {
class_exists(Transaction::class);                $transaction = oxNew(Transaction::class);
                /* @var $transaction Transaction */
                if ($transaction->loadByTransactionAndSpace($completion->getTransactionId(), $completion->getSpaceId())) {
                    $transaction->updateLineItems();
                    $this->send($completion);
                    if ($completion->getState() === self::getFailedState()) {
                        $errors[] = $completion->getFailureReason();
                    }
                } else {
                    $errors[] = WalleeModule::instance()->translate("Unable to load transaction !id in space !space", true, array('!id' => $completion->getTransactionId(), '!space' => $completion->getSpaceId()));
                }
            } else {
                WalleeModule::log(Logger::ERROR, "Unable to load pending job {$job['WLEJOBID']} / {$job['WLESPACEID']}.");
            }
        }
        return $errors;
    }
}