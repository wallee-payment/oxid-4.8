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

use Wle\Wallee\Core\WalleeModule;
use Wle\Wallee\Core\Webhook\Request;
use Wle\Wallee\Core\Webhook\Service as WebhookService;

/**
 * Class Webhook.
 */
class Webhook extends \oxview
{
	public function notify()
	{
        header("HTTP/1.1 500 Internal Server Error");
        ob_start();
        $webhookService = new WebhookService();

        $requestBody = trim(file_get_contents("php://input"));
        set_error_handler(array(
            __CLASS__,
            'handleWebhookErrors'
        ));
        try {
        	$request = new Request(json_decode($requestBody));
        	$webhookModel = $webhookService->getWebhookEntityForId($request->getListenerEntityId());
        	WalleeModule::log(Logger::INFO, "Webhook process started.", [$webhookModel, $requestBody]);
            if ($webhookModel === null) {
                WalleeModule::log(Logger::ERROR, "Could not retrieve webhook model for listener entity id: {$request->getListenerEntityId()}.");
                header("HTTP/1.1 500 Internal Server Error");
                echo "Could not retrieve webhook model for listener entity id: {$request->getListenerEntityId()}.";
                exit();
            }
            $webhookHandlerClassName = $webhookModel->getHandlerClassName();
            $webhookHandler = $webhookHandlerClassName::instance();
            $webhookHandler->process($request);
        } catch (\Exception $e) {
            header("HTTP/1.1 500 Internal Server Error");
            echo($e->getMessage());
            exit();
        }
        header("HTTP/1.1 200 OK");
        $stuff = ob_get_contents();
        ob_end_clean();
        if($stuff) {
            WalleeModule::log(Logger::WARNING, "Webhook process output was caught and not removed: $stuff");
        }

        exit();
    }

    /**
     * @param $errno
     * @param $errstr
     * @param $errfile
     * @param $errline
     * @return bool
     * @throws \ErrorException
     */
    public static function handleWebhookErrors($errno, $errstr, $errfile, $errline)
    {
        $fatal = E_ERROR | E_CORE_ERROR | E_COMPILE_ERROR | E_USER_ERROR | E_RECOVERABLE_ERROR;
        if ($errno & $fatal) {
            throw new \ErrorException($errstr, $errno, E_ERROR, $errfile, $errline);
        }
        return false;
    }

    /**
     * @return string|void
     * @throws \Exception
     */
    public function render()
    {
        throw new \Exception("This page may not be rendered.");
    }
}