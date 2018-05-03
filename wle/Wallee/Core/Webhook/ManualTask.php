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
namespace Wle\Wallee\Core\Webhook;
require_once(OX_BASE_PATH . 'modules/wle/Wallee/autoload.php');

/**
 * Webhook processor to handle manual task state transitions.
 */
class ManualTask extends AbstractWebhook {

    /**
     * Updates the number of open manual tasks.
     *
     * @param \Wle\Wallee\Core\Webhook\Request $request
     */
    public function process(Request $request){
        \Wle\Wallee\Core\Service\ManualTask::instance()->update();
    }
}