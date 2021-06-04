<?php

namespace Pyz\Zed\PriceProductOfferStorage;

use Pyz\Zed\Synchronization\SynchronizationConfig;
use Spryker\Zed\PriceProductOfferStorage\PriceProductOfferStorageConfig as SprykerPriceProductOfferStorageConfig;

class PriceProductOfferStorageConfig extends SprykerPriceProductOfferStorageConfig
{
    /**
     * @return string|null
     */
    public function getPriceProductOfferSynchronizationPoolName(): ?string
    {
        return SynchronizationConfig::DEFAULT_SYNCHRONIZATION_POOL_NAME;
    }
}
