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

use Monolog\Logger;
use Wle\Wallee\Core\Service\CompletionService;
use Wle\Wallee\Core\Service\RefundService;
use Wle\Wallee\Core\Service\VoidService;
use Wle\Wallee\Core\WalleeModule;

/**
 * Class Cron.
 */
class Cron extends \oxview
{
    public function init()
    {
        $this->_Cron_init_parent();
        $this->endRequestPrematurely();

        $oxid = WalleeModule::instance()->getRequestParameter('oxid');
        if (!$oxid) {
            WalleeModule::log(Logger::WARNING, 'CRON called without id.');
            exit();
        }

        try {
            \oxdb::getDb()->startTransaction();
            $result = \Wle\Wallee\Application\Model\Cron::setProcessing($oxid);
            \oxdb::getDb()->commitTransaction();
            if (!$result) {
                exit();
            }
        } catch (\Exception $e) {
            WalleeModule::log(Logger::ERROR, "Updating cron failed: {$e->getMessage()}.");
            WalleeModule::rollback();
            exit();
        }

        $errors = array_merge(
            CompletionService::instance()->resendAll(),
            VoidService::instance()->resendAll(),
            RefundService::instance()->resendAll()
        );

        try {
            \oxdb::getDb()->startTransaction();
            $result = \Wle\Wallee\Application\Model\Cron::setComplete($oxid, implode('. ', $errors));
            \Wle\Wallee\Application\Model\Cron::insertNewPendingCron();
            \oxdb::getDb()->commitTransaction();
            if (!$result) {
                WalleeModule::log(Logger::ERROR, "Could not update finished cron job.");
                exit();
            }
        } catch (\Exception $e) {
            WalleeModule::rollback();
            WalleeModule::log(Logger::ERROR, "Could not update finished cron job.");
            exit();
        }
        exit();
    }

    private function endRequestPrematurely()
    {
        ob_end_clean();
        // Return request but keep executing
        set_time_limit(0);
        ignore_user_abort(true);
        ob_start();
        if (session_id()) {
            session_write_close();
        }
        header("Content-Encoding: none");
        header("Connection: close");
        header('Content-Type: text/javascript');
        ob_end_flush();
        flush();
        if (is_callable('fastcgi_finish_request')) {
            fastcgi_finish_request();
        }
    }

    protected function _Cron_init_parent()
    {
        return parent::init();
    }

    public static function getCronUrl()
    {
        \Wle\Wallee\Application\Model\Cron::cleanUpHangingCrons();
        \Wle\Wallee\Application\Model\Cron::insertNewPendingCron();
        $oxid = \Wle\Wallee\Application\Model\Cron::getCurrentPendingCron();
        return $oxid ? WalleeModule::getControllerUrl('wle_wallee_Cron', null, $oxid) : null;
    }
}