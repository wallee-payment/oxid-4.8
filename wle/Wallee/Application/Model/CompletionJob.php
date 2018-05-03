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

use Wle\Wallee\Core\Service\CompletionService;
use Wle\Wallee\Core\Service\JobService;

/**
 * Class CompletionJob.
 * CompletionJob model.
 */
class CompletionJob extends AbstractJob
{
    /**
     * Class constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->init('wleWallee_completionjob');
    }

    /**
     * @return JobService
     */
    protected function getService()
    {
        return CompletionService::instance();
    }
}