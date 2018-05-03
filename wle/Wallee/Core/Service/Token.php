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

use Wallee\Sdk\Model\EntityQuery;
use Wallee\Sdk\Model\EntityQueryFilter;
use Wallee\Sdk\Model\EntityQueryFilterType;
use Wallee\Sdk\Model\TokenVersion;
use Wallee\Sdk\Model\TokenVersionState;
use Wle\Wallee\Core\WalleeModule;

/**
 * This service provides functions to deal with Wallee tokens.
 */
class Token extends AbstractService
{

    /**
     * The token API service.
     *
     * @var \Wallee\Sdk\Service\TokenService
     */
    private $tokenService;

    /**
     * The token version API service.
     *
     * @var \Wallee\Sdk\Service\TokenVersionService
     */
    private $versionService;

    public function updateTokenVersion($spaceId, $tokenVersionId)
    {
        $version = $this->getTokenVersionService()->read($spaceId, $tokenVersionId);
        $this->updateInfo($spaceId, $version);
    }

    public function updateToken($spaceId, $tokenId)
    {
        $query = new EntityQuery();
        $filter = new EntityQueryFilter();
        $filter->setType(EntityQueryFilterType::_AND);
        $filter->setChildren(
            array(
                $this->createEntityFilter('token.id', $tokenId),
                $this->createEntityFilter('state', TokenVersionState::ACTIVE)
            ));
        $query->setFilter($filter);
        $query->setNumberOfEntities(1);
        $versions = $this->getTokenVersionService()->search($spaceId, $query);
        if (!empty($versions)) {
            $this->updateInfo($spaceId, current($versions));
        } else {
            $token = $this->loadToken($spaceId, $tokenId);
            $token->delete();
        }
    }

    protected function updateInfo($spaceId, TokenVersion $version)
    {
        $token = $this->loadToken($spaceId, $version->getToken()->getId());
        if (!in_array($version->getToken()->getState(),
            array(
                TokenVersionState::ACTIVE,
                TokenVersionState::UNINITIALIZED
            ))) {
            $token->delete();
            return;
        }

        $token->setCustomerId($version->getToken()->getCustomerId());
        $token->setName($version->getName());
        $token->setPaymentMethodId($version->getPaymentConnectorConfiguration()->getPaymentMethodConfiguration()->getPaymentMethod());
        $token->setConnectorId($version->getPaymentConnectorConfiguration()->getConnector());

        $token->setSpaceId($spaceId);
        $token->setState($version->getToken()->getState());
        $token->setTokenId($version->getToken()->getId());
        $token->save();
    }

    protected function loadToken($spaceId, $tokenId)
    {
class_exists(\Wle\Wallee\Application\Model\Token::class);        $token = oxNew(\Wle\Wallee\Application\Model\Token::class);
        /* @var $token \Wle\Wallee\Application\Model\Token */
        if ($token->loadByToken($spaceId, $tokenId)) {
            return $token;
        }
        throw new \Exception("Unable to load token by token $tokenId in space $spaceId.");
    }

    public function deleteToken($spaceId, $tokenId)
    {
        $this->getTokenService()->delete($spaceId, $tokenId);
    }

    /**
     * Returns the token API service.
     *
     * @return \Wallee\Sdk\Service\TokenService
     */
    protected function getTokenService()
    {
        if ($this->tokenService == null) {
            $this->tokenService = new \Wallee\Sdk\Service\TokenService(WalleeModule::instance()->getApiClient());
        }

        return $this->tokenService;
    }

    /**
     * Returns the token version API service.
     *
     * @return \Wallee\Sdk\Service\TokenVersionService
     */
    protected function getTokenVersionService()
    {
        if ($this->versionService == null) {
            $this->versionService = new \Wallee\Sdk\Service\TokenVersionService(WalleeModule::instance()->getApiClient());
        }

        return $this->versionService;
    }
}