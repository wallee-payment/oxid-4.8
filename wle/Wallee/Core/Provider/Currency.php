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
namespace Wle\Wallee\Core\Provider;
require_once(OX_BASE_PATH . 'modules/wle/Wallee/autoload.php');

use Wallee\Sdk\Service\CurrencyService;
use Wle\Wallee\Core\WalleeModule;

/**
 * Provider of currency information from the gateway.
 */
class Currency extends AbstractProvider
{

    protected function __construct()
    {
        parent::__construct('ox_Wallee_currency');
    }

    /**
     * Returns the currency by the given code.
     *
     * @param string $code
     * @return \Wallee\Sdk\Model\RestCurrency
     */
    public function find($code)
    {
        return parent::find($code);
    }

    /**
     * Returns a list of currencies.
     *
     * @return \Wallee\Sdk\Model\RestCurrency[]
     */
    public function getAll()
    {
        return parent::getAll();
    }

    /**
     * @return array|\Wallee\Sdk\Model\RestCurrency[]
     * @throws \Wallee\Sdk\ApiException
     */
    protected function fetchData()
    {
        $service = new CurrencyService(WalleeModule::instance()->getApiClient());
        return $service->all();
    }

    protected function getId($entry)
    {
        /* @var \Wallee\Sdk\Model\RestCurrency $entry */
        return $entry->getCurrencyCode();
    }
}