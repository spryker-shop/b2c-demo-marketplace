<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\OauthClient\Business;

use Pyz\Zed\OauthClient\Business\Expander\RequestAuthorizationDataExpander;
use Spryker\Zed\OauthClient\Business\Expander\RequestAuthorizationDataExpanderInterface;
use Spryker\Zed\OauthClient\Business\OauthClientBusinessFactory as SprykerOauthClientBusinessFactory;

/**
 * @method \Spryker\Zed\OauthClient\OauthClientConfig getConfig()
 * @method \Spryker\Zed\OauthClient\Persistence\OauthClientRepositoryInterface getRepository()
 * @method \Spryker\Zed\OauthClient\Persistence\OauthClientEntityManagerInterface getEntityManager()
 */
class OauthClientBusinessFactory extends SprykerOauthClientBusinessFactory
{
    /**
     * @return \Spryker\Zed\OauthClient\Business\Expander\RequestAuthorizationDataExpanderInterface
     */
    public function createRequestAuthorizationDataExpander(): RequestAuthorizationDataExpanderInterface
    {
        return new RequestAuthorizationDataExpander($this->createOauthAccessTokenProvider(), $this->getConfig());
    }
}
