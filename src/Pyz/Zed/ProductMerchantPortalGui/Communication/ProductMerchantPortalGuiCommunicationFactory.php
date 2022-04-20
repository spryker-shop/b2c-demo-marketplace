<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductMerchantPortalGui\Communication;

use Pyz\Zed\ProductMerchantPortalGui\Communication\Generator\CreateProductUrlGenerator;
use Spryker\Zed\ProductMerchantPortalGui\Communication\Generator\CreateProductUrlGeneratorInterface;
use Spryker\Zed\ProductMerchantPortalGui\Communication\ProductMerchantPortalGuiCommunicationFactory as SprykerProductMerchantPortalGuiCommunicationFactory;

/**
 * @method \Pyz\Zed\ProductMerchantPortalGui\ProductMerchantPortalGuiConfig getConfig()
 */
class ProductMerchantPortalGuiCommunicationFactory extends SprykerProductMerchantPortalGuiCommunicationFactory
{
    /**
     * @return \Spryker\Zed\ProductMerchantPortalGui\Communication\Generator\CreateProductUrlGeneratorInterface
     */
    public function createCreateProductUrlGenerator(): CreateProductUrlGeneratorInterface
    {
        return new CreateProductUrlGenerator();
    }
}
