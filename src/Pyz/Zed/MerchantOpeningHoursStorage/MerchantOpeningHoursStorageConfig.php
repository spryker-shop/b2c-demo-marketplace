<?php

namespace Pyz\Zed\MerchantOpeningHoursStorage;

use Pyz\Zed\Synchronization\SynchronizationConfig;
use Spryker\Zed\MerchantOpeningHoursStorage\MerchantOpeningHoursStorageConfig as SprykerMerchantOpeningHoursStorageStorageConfig;

class MerchantOpeningHoursStorageConfig extends SprykerMerchantOpeningHoursStorageStorageConfig
{
    /**
     * @return string|null
     */
    public function getMerchantOpeningHoursSynchronizationPoolName(): ?string
    {
        return SynchronizationConfig::DEFAULT_SYNCHRONIZATION_POOL_NAME;
    }
}
