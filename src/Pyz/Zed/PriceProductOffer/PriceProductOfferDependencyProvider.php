<?php
namespace Pyz\Zed\PriceProductOffer;

use Spryker\Zed\PriceProductOffer\PriceProductOfferDependencyProvider as SprykerPriceProductOfferDependencyProvider;
use Spryker\Zed\PriceProductOfferVolume\Communication\Plugin\PriceProductOffer\PriceProductOfferVolumeExtractorPlugin;

class PriceProductOfferDependencyProvider extends SprykerPriceProductOfferDependencyProvider
{
    /**
     * @return \Spryker\Zed\PriceProductOfferExtension\Dependency\Plugin\PriceProductOfferExtractorPluginInterface[]
     */
    protected function getPriceProductOfferExtractorPlugins(): array
    {
        return [
            new PriceProductOfferVolumeExtractorPlugin(),
        ];
    }
}
