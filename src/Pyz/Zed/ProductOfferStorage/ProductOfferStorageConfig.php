<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductOfferStorage;

use Pyz\Zed\Synchronization\SynchronizationConfig;
use Spryker\Zed\ProductOfferStorage\ProductOfferStorageConfig as SprykerProductOfferStorageConfig;

class ProductOfferStorageConfig extends SprykerProductOfferStorageConfig
{
    /**
     * @return string
     */
    public function getProductOfferSynchronizationPoolName(): string
    {
        return SynchronizationConfig::DEFAULT_SYNCHRONIZATION_POOL_NAME;
    }
}
