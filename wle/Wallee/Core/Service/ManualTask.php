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
use Wallee\Sdk\Model\ManualTaskState;
use Wallee\Sdk\Service\ManualTaskService;
use Wle\Wallee\Application\Model\Alert;
use Wle\Wallee\Core\WalleeModule;

/**
 * This service provides methods to handle manual tasks.
 */
class ManualTask extends AbstractService
{
    /**
     * Updates the number of open manual tasks.
     *
     * @throws \Exception
     * @return int
     */
    public function update()
    {
        try {
            $service = new ManualTaskService(WalleeModule::instance()->getApiClient());

            $taskCount = $service->count(WalleeModule::settings()->getSpaceId(),
                $this->createEntityFilter('state', ManualTaskState::OPEN));

            Alert::setCount(Alert::KEY_MANUAL_TASK, $taskCount);

            return $taskCount;
        } catch (\Exception $e) {
            WalleeModule::log(Logger::ERROR, "Unable to update manual tasks: {$e->getMessage()} - {$e->getTraceAsString()}.");
            throw $e;
        }
    }
}