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

use Wallee\Sdk\Service\LanguageService;
use Wle\Wallee\Core\WalleeModule;

/**
 * Provider of language information from the gateway.
 */
class Language extends AbstractProvider
{

    protected function __construct()
    {
        parent::__construct('ox_Wallee_languages');
    }

    /**
     * Returns the language by the given code.
     *
     * @param string $code
     * @return \Wallee\Sdk\Model\RestLanguage
     */
    public function find($code)
    {
        return parent::find($code);
    }

    /**
     * Returns the primary language in the given group.
     *
     * @param string $code
     * @return bool|\Wallee\Sdk\Model\RestLanguage
     */
    public function findPrimary($code)
    {
        $code = substr($code, 0, 2);
        foreach ($this->getAll() as $language) {
            if ($language->getIso2Code() == $code && $language->getPrimaryOfGroup()) {
                return $language;
            }
        }

        return false;
    }

    /**
     * @param $iso
     * @return bool|\Wallee\Sdk\Model\RestLanguage
     */
    public function findByIsoCode($iso)
    {
        foreach ($this->getAll() as $language) {
            if ($language->getIso2Code() == $iso || $language->getIso3Code() == $iso) {
                return $language;
            }
        }
        return false;
    }

    /**
     * Returns a list of language.
     *
     * @return \Wallee\Sdk\Model\RestLanguage[]
     */
    public function getAll()
    {
        return parent::getAll();
    }

    /**
     * @return array|\Wallee\Sdk\Model\RestLanguage[]
     * @throws \Wallee\Sdk\ApiException
     */
    protected function fetchData()
    {
        $service = new LanguageService(WalleeModule::instance()->getApiClient());
        return $service->all();
    }

    protected function getId($entry)
    {
        /* @var \Wallee\Sdk\Model\RestLanguage $entry */
        return $entry->getIetfCode();
    }
}