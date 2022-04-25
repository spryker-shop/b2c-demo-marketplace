<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Client\ProductReview;

use Spryker\Client\ProductReview\Plugin\Elasticsearch\QueryExpander\PaginatedProductReviewsQueryExpanderPlugin;
use Spryker\Client\ProductReview\Plugin\Elasticsearch\QueryExpander\ProductRatingAggregationBulkQueryExpanderPlugin;
use Spryker\Client\ProductReview\Plugin\Elasticsearch\QueryExpander\SortByCreatedAtQueryExpanderPlugin;
use Spryker\Client\ProductReview\Plugin\Elasticsearch\ResultFormatter\PaginatedProductReviewsResultFormatterPlugin;
use Spryker\Client\ProductReview\Plugin\Elasticsearch\ResultFormatter\ProductRatingAggregationBulkResultFormatterPlugin;
use Spryker\Client\ProductReview\Plugin\Elasticsearch\ResultFormatter\ProductReviewsResultFormatterPlugin;
use Spryker\Client\ProductReview\ProductReviewDependencyProvider as SprykerProductReviewDependencyProvider;

class ProductReviewDependencyProvider extends SprykerProductReviewDependencyProvider
{
    /**
     * @return \Spryker\Client\SearchExtension\Dependency\Plugin\QueryExpanderPluginInterface[]
     */
    protected function getProductReviewsBulkQueryExpanderPlugins(): array
    {
        return [
            new PaginatedProductReviewsQueryExpanderPlugin(),
            new ProductRatingAggregationBulkQueryExpanderPlugin(),
            new SortByCreatedAtQueryExpanderPlugin(),
        ];
    }

    /**
     * @return \Spryker\Client\Search\Dependency\Plugin\ResultFormatterPluginInterface[]|\Spryker\Client\SearchExtension\Dependency\Plugin\ResultFormatterPluginInterface[]
     */
    public function getProductReviewsBulkSearchResultFormatterPlugins(): array
    {
        return [
            new ProductReviewsResultFormatterPlugin(),
            new PaginatedProductReviewsResultFormatterPlugin(),
            new ProductRatingAggregationBulkResultFormatterPlugin(),
        ];
    }
}
