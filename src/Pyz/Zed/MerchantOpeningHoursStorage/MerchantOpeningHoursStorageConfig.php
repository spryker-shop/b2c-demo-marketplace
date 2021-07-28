<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

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
