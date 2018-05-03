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

/**
 * This entity holds data about a token on the gateway.
 */
class Token extends \oxbase
{

	private $_sTableName = 'wleWallee_token';
	protected $_aSkipSaveFields = ['oxtimestamp', 'WLEUPDATED'];

    /**
     * Class constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->init($this->_sTableName);
    }

    public function getTokenId()
    {
        return $this->getFieldData('wletokenid');
    }

    public function getState()
    {
        return $this->getFieldData('wlestate');
    }

    public function getSpaceId()
    {
        return $this->getFieldData('wlespaceid');
    }

    public function getName()
    {
        return $this->getFieldData('wlename');
    }

    public function getCustomerId()
    {
        return $this->getFieldData('wlecustomerid');
    }

    public function getPaymentMethodId()
    {
        return $this->getFieldData('wlepaymentmethodid');
    }

    public function getConnectorId()
    {
        return $this->getFieldData('wleconnectorid');
    }

    public function setTokenId($value)
    {
        $this->_setFieldData('wletokenid', $value);
    }

    public function setState($value)
    {
        $this->_setFieldData('wlestate', $value);
    }

    public function setSpaceId($value)
    {
        $this->_setFieldData('wlespaceid', $value);
    }

    public function setName($value)
    {
        $this->_setFieldData('wlename', $value);
    }

    public function setCustomerId($value)
    {
        $this->_setFieldData('wlecustomerid', $value);
    }

    public function setPaymentMethodId($value)
    {
        $this->_setFieldData('wlepaymentmethodid', $value);
    }

    public function setConnectorId($value)
    {
        $this->_setFieldData('wleconnectorid', $value);
    }

    public function loadByToken($spaceId, $tokenId)
    {
        $query = $this->buildSelectString(array('wlespaceid' => $spaceId, 'wletokenid' => $tokenId));
        return $this->assignRecord($query);
    }
}