<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ExampleProductSalePage\Persistence;

use Orm\Zed\Product\Persistence\SpyProductAbstractQuery;
use Orm\Zed\ProductLabel\Persistence\SpyProductLabelProductAbstractQuery;
use Orm\Zed\ProductLabel\Persistence\SpyProductLabelQuery;

/**
 * @method \Pyz\Zed\ExampleProductSalePage\Persistence\ExampleProductSalePagePersistenceFactory getFactory()
 */
interface ExampleProductSalePageQueryContainerInterface
{
    /**
     * @api
     *
     * @psalm-suppress TooManyTemplateParams
     *
     * @param string $labelName
     *
     * @return \Orm\Zed\ProductLabel\Persistence\SpyProductLabelQuery<\Orm\Zed\ProductLabel\Persistence\SpyProductLabel>
     */
    public function queryProductLabelByName($labelName): SpyProductLabelQuery;

    /**
     * @api
     *
     * @psalm-suppress TooManyTemplateParams
     *
     * @param int $idProductLabel
     * @param string $priceMode
     *
     * @return \Orm\Zed\ProductLabel\Persistence\SpyProductLabelProductAbstractQuery
     */
    public function queryRelationsBecomingInactive(int $idProductLabel, string $priceMode): SpyProductLabelProductAbstractQuery;

    /**
     * @api
     *
     * @psalm-suppress TooManyTemplateParams
     *
     * @param int $idProductLabel
     * @param int $currentStoreId
     * @param int $currentCurrencyId
     * @param string $priceMode
     *
     * @return \Orm\Zed\Product\Persistence\SpyProductAbstractQuery
     */
    public function queryRelationsBecomingActive(
        int $idProductLabel,
        int $currentStoreId,
        int $currentCurrencyId,
        string $priceMode,
    ): SpyProductAbstractQuery;
}
