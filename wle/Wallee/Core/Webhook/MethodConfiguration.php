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
use Wle\Wallee\Core\Service\PaymentService;

/**
 * Webhook processor to handle payment method configuration state transitions.
 */
class MethodConfiguration extends AbstractWebhook
{

    /**
     * Synchronizes the payment method configurations on state transition.
     * @param Request $request
     * @throws \Exception
     * @throws \Wallee\Sdk\ApiException
     */
    public function process(Request $request)
    {
        $paymentService = new PaymentService();
        $paymentService->synchronize();
    }
}