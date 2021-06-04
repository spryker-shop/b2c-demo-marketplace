<?php

namespace Pyz\Client\PriceProductOfferStorage;

use Spryker\Client\PriceProductOfferStorage\PriceProductOfferStorageDependencyProvider as SprykerPriceProductOfferStorageDependencyProvider;
use Spryker\Client\PriceProductOfferVolume\Plugin\PriceProductOfferStorage\PriceProductOfferVolumeExtractorPlugin;

class PriceProductOfferStorageDependencyProvider extends SprykerPriceProductOfferStorageDependencyProvider
{
    /**
     * @return \Spryker\Client\PriceProductOfferStorageExtension\Dependency\Plugin\PriceProductOfferStoragePriceExtractorPluginInterface[]
     */
    protected function getPriceProductOfferStoragePriceExtractorPlugins(): array
    {
        return [
            new PriceProductOfferVolumeExtractorPlugin(),
        ];
    }
}
