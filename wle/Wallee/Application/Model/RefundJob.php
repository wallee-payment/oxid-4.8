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

use Wle\Wallee\Core\Service\JobService;
use Wle\Wallee\Core\Service\RefundService;

/**
 * Class RefundJob.
 * RefundJob model.
 */
class RefundJob extends AbstractJob
{
    private $formReductions;

    public function getRestock() {
        return $this->getFieldData('wlerestock');
    }

    public function setRestock($value){
        $this->_setFieldData('wlerestock', $value);
    }

    /**
     * Class constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->init('wleWallee_refundjob');
    }

    public function setFormReductions(array $formReductions)
    {
        $this->formReductions = $formReductions;
    }
    public function getFormReductions(){
        return $this->formReductions;
    }

    /**
     * @return JobService
     */
    protected function getService()
    {
        return RefundService::instance();
    }
}