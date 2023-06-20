<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\OauthClient\Business\Expander;

use Generated\Shared\Transfer\AccessTokenRequestOptionsTransfer;
use Generated\Shared\Transfer\AccessTokenRequestTransfer;
use Generated\Shared\Transfer\MessageAttributesTransfer;
use Spryker\Zed\OauthClient\Business\Expander\RequestAuthorizationDataExpander as SprykerRequestAuthorizationDataExpander;

class RequestAuthorizationDataExpander extends SprykerRequestAuthorizationDataExpander
{
    /**
     * @param \Generated\Shared\Transfer\MessageAttributesTransfer $messageAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\MessageAttributesTransfer
     */
    public function expandMessageAttributes(
        MessageAttributesTransfer $messageAttributesTransfer,
    ): MessageAttributesTransfer {
        $accessTokenRequestOptionsTransfer = (new AccessTokenRequestOptionsTransfer())
            ->setAudience($this->oauthClientConfig->getOauthOptionAudienceForMessageBroker());

        if ($messageAttributesTransfer->getStoreReference()) {
            $accessTokenRequestOptionsTransfer->setStoreReference($messageAttributesTransfer->getStoreReference());
        }

        $accessTokenRequestTransfer = (new AccessTokenRequestTransfer())
            ->setGrantType($this->oauthClientConfig->getOauthGrantTypeForMessageBroker())
            ->setProviderName($this->oauthClientConfig->getOauthProviderNameForMessageBroker())
            ->setAccessTokenRequestOptions($accessTokenRequestOptionsTransfer);

        $accessTokenRequestTransfer->setAccessTokenRequestOptions($accessTokenRequestOptionsTransfer);

        $messageAttributesTransfer->setAuthorization($this->getAuthorizationValue($accessTokenRequestTransfer));

        return $messageAttributesTransfer;
    }
}
