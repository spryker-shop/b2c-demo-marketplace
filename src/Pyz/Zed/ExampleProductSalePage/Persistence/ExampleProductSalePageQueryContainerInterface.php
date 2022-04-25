<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ExampleProductSalePage\Persistence;

use Orm\Zed\Product\Persistence\SpyProductAbstractQuery;
use Orm\Zed\ProductLabel\Persistence\SpyProductLabelProductAbstractQuery;

/**
 * @method \Pyz\Zed\ExampleProductSalePage\Persistence\ExampleProductSalePagePersistenceFactory getFactory()
 */
interface ExampleProductSalePageQueryContainerInterface
{
    /**
     * @api
     *
     * @param string $labelName
     *
     * @return \Orm\Zed\ProductLabel\Persistence\SpyProductLabelQuery
     */
    public function queryPyzProductLabelByName($labelName);

    /**
     * @api
     *
     * @param int $idProductLabel
     * @param string $priceMode
     *
     * @return \Orm\Zed\ProductLabel\Persistence\SpyProductLabelProductAbstractQuery
     */
    public function queryPyzRelationsBecomingInactive(int $idProductLabel, string $priceMode): SpyProductLabelProductAbstractQuery;

    /**
     * @api
     *
     * @param int $idProductLabel
     * @param int $currentStoreId
     * @param int $currentCurrencyId
     * @param string $priceMode
     *
     * @return \Orm\Zed\Product\Persistence\SpyProductAbstractQuery
     */
    public function queryPyzRelationsBecomingActive(
        int $idProductLabel,
        int $currentStoreId,
        int $currentCurrencyId,
        string $priceMode
    ): SpyProductAbstractQuery;
}
