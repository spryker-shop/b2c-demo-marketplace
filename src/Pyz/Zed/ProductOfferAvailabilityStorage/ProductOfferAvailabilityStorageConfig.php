<?php

namespace Pyz\Zed\ProductOfferAvailabilityStorage;

use Pyz\Zed\Synchronization\SynchronizationConfig;
use Spryker\Zed\ProductOfferAvailabilityStorage\ProductOfferAvailabilityStorageConfig as SprykerProductOfferAvailabilityStorageConfig;

class ProductOfferAvailabilityStorageConfig extends SprykerProductOfferAvailabilityStorageConfig
{
    /**
     * @return string|null
     */
    public function getProductOfferAvailabilitySynchronizationPoolName(): ?string
    {
        return SynchronizationConfig::DEFAULT_SYNCHRONIZATION_POOL_NAME;
    }
}
