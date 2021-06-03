<?php

namespace Pyz\Zed\MerchantProductOfferStorage;

use Pyz\Zed\Synchronization\SynchronizationConfig;
use Spryker\Zed\MerchantProductOfferStorage\MerchantProductOfferStorageConfig as SprykerMerchantProductOfferStorageConfig;

class MerchantProductOfferStorageConfig extends SprykerMerchantProductOfferStorageConfig
{
    /**
     * @api
     *
     * @return string|null
     */
    public function getMerchantProductOfferSynchronizationPoolName(): ?string
    {
        return SynchronizationConfig::DEFAULT_SYNCHRONIZATION_POOL_NAME;
    }
}
