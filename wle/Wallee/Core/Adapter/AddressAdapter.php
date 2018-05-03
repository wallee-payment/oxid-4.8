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


namespace Wle\Wallee\Core\Adapter;
require_once(OX_BASE_PATH . 'modules/wle/Wallee/autoload.php');

use Wallee\Sdk\Model\AddressCreate;
use Wallee\Sdk\Model\Gender;
use Wle\Wallee\Core\WalleeModule;

/**
 * Class AddressAdapter
 * Converts Oxid Address Data into data which can be fed into the Wallee SDK.
 *
 * @codeCoverageIgnore
 */
class AddressAdapter implements IAddressAdapter
{
    private $shipping = null;
    private $billing = null;

    public function __construct(\oxaddress $shipping = null, \oxuser $billing = null)
    {
        $this->shipping = $shipping;
        $this->billing = $billing;
    }

    public function getShippingAddressData()
    {
        if ($this->shipping) {
            return $this->convertAddress($this->shipping);
        }
        return null;
    }

    public function getBillingAddressData()
    {
        if ($this->billing) {
            return $this->convertAddress($this->billing);
        }
        return null;
    }

    private function convertAddress($address)
    {
        $addressCreate = new AddressCreate();
        $addressCreate->setGivenName($address->getFieldData('oxfname'));
        $addressCreate->setFamilyName($address->getFieldData('oxlname'));
        $addressCreate->setCity($address->getFieldData('oxcity'));
class_exists('oxcountry');        $country = oxNew('oxcountry');
        /* @var $country \oxcountry */
        if ($country->load($address->getFieldData('oxcountryid'))) {
            $addressCreate->setCountry($country->getFieldData('oxisoalpha2'));
        }
        $addressCreate->setStreet(trim($address->getFieldData('oxstreet') . ' ' . $address->getFieldData('oxoxstreetnr')));
        $addressCreate->setPhoneNumber($address->getFieldData('oxfon'));
        $addressCreate->setPostalState($address->getFieldData('oxstate'));
        $addressCreate->setPostCode($address->getFieldData('oxzip'));
        $addressCreate->setOrganizationName($address->getFieldData('oxcompany'));

        $salutation = $address->getFieldData('oxsal');
        if (strtolower($salutation) === 'mr') {
            /** @noinspection PhpParamsInspection */
            $addressCreate->setGender(Gender::MALE);
        } else if (strtolower($salutation) === 'Mrs') {
            /** @noinspection PhpParamsInspection */
            $addressCreate->setGender(Gender::FEMALE);
        }
        $addressCreate->setSalutation($salutation);
        return $addressCreate;
    }

}