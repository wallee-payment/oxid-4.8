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

use Wallee\Sdk\Service\LabelDescriptionService;
use Wle\Wallee\Core\WalleeModule;

/**
 * Provider of label descriptor information from the gateway.
 */
class LabelDescription extends AbstractProvider
{

    protected function __construct()
    {
        parent::__construct('ox_Wallee_label_descriptor');
    }

    /**
     * Returns the label descriptor by the given code.
     *
     * @param int $id
     * @return \Wallee\Sdk\Model\LabelDescriptor
     */
    public function find($id)
    {
        return parent::find($id);
    }

    /**
     * Returns a list of label descriptors.
     *
     * @return \Wallee\Sdk\Model\LabelDescriptor[]
     */
    public function getAll()
    {
        return parent::getAll();
    }

    /**
     * @return array|\Wallee\Sdk\Model\LabelDescriptor[]
     * @throws \Wallee\Sdk\ApiException
     */
    protected function fetchData()
    {
        $service = new LabelDescriptionService(WalleeModule::instance()->getApiClient());
        return $service->all();
    }

    protected function getId($entry)
    {
        /* @var \Wallee\Sdk\Model\LabelDescriptor $entry */
        return $entry->getId();
    }
}