<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\PriceProduct;

use Spryker\Zed\AclEntity\Communication\Plugin\PriceProduct\AclEntityOrphanPriceProductStoreRemovalVoterPlugin;
use Spryker\Zed\PriceProduct\PriceProductDependencyProvider as SprykerPriceProductDependencyProvider;
use Spryker\Zed\PriceProductOffer\Communication\Plugin\PriceProduct\PriceProductOfferPriceDimensionConcreteSaverPlugin;
use Spryker\Zed\PriceProductOffer\Communication\Plugin\PriceProduct\PriceProductOfferPriceDimensionQueryCriteriaPlugin;
use Spryker\Zed\PriceProductOffer\Communication\Plugin\PriceProduct\PriceProductOfferPriceProductDimensionExpanderStrategyPlugin;
use Spryker\Zed\PriceProductVolume\Communication\Plugin\PriceProduct\PriceProductVolumeValidatorPlugin;
use Spryker\Zed\PriceProductVolume\Communication\Plugin\PriceProductExtension\PriceProductVolumeExtractorPlugin;

/**
 * Copyright © 2017-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */
class PriceProductDependencyProvider extends SprykerPriceProductDependencyProvider
{
    /**
     * @return array<\Spryker\Zed\PriceProductExtension\Dependency\Plugin\PriceProductReaderPricesExtractorPluginInterface>
     */
    protected function getPriceProductPricesExtractorPlugins(): array
    {
        return [
            new PriceProductVolumeExtractorPlugin(),
        ];
    }

    /**
     * {@inheritDoc}
     *
     * @return array<\Spryker\Zed\PriceProductExtension\Dependency\Plugin\PriceDimensionQueryCriteriaPluginInterface>
     */
    protected function getPriceDimensionQueryCriteriaPlugins(): array
    {
        return array_merge(parent::getPriceDimensionQueryCriteriaPlugins(), [
            new PriceProductOfferPriceDimensionQueryCriteriaPlugin(),
        ]);
    }

    /**
     * @return array<\Spryker\Zed\PriceProductExtension\Dependency\Plugin\PriceDimensionConcreteSaverPluginInterface>
     */
    protected function getPriceDimensionConcreteSaverPlugins(): array
    {
        return [
            new PriceProductOfferPriceDimensionConcreteSaverPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Service\PriceProductExtension\Dependency\Plugin\PriceProductDimensionExpanderStrategyPluginInterface>
     */
    protected function getPriceProductDimensionExpanderStrategyPlugins(): array
    {
        return [
            new PriceProductOfferPriceProductDimensionExpanderStrategyPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\PriceProductExtension\Dependency\Plugin\PriceProductValidatorPluginInterface>
     */
    protected function getPriceProductValidatorPlugins(): array
    {
        return [
            new PriceProductVolumeValidatorPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\PriceProductExtension\Dependency\Plugin\OrphanPriceProductStoreRemovalVoterPluginInterface>
     */
    protected function getOrphanPriceProductStoreRemovalVoterPlugins(): array
    {
        return [
            new AclEntityOrphanPriceProductStoreRemovalVoterPlugin(),
        ];
    }
}
