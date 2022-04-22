<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductMerchantPortalGui\Communication;

use Pyz\Zed\ProductMerchantPortalGui\Communication\Generator\CreatePyzProductUrlGenerator;
use Pyz\Zed\ProductMerchantPortalGui\Communication\Generator\CreatePyzProductUrlGeneratorInterface;
use Spryker\Zed\ProductMerchantPortalGui\Communication\ProductMerchantPortalGuiCommunicationFactory as SprykerProductMerchantPortalGuiCommunicationFactory;

/**
 * @method \Pyz\Zed\ProductMerchantPortalGui\ProductMerchantPortalGuiConfig getConfig()
 */
class ProductMerchantPortalGuiCommunicationFactory extends SprykerProductMerchantPortalGuiCommunicationFactory
{
    /**
     * @return \Pyz\Zed\ProductMerchantPortalGui\Communication\Generator\CreatePyzProductUrlGeneratorInterface;
     */
    public function createPyzCreateProductUrlGenerator(): CreatePyzProductUrlGeneratorInterface
    {
        return new CreatePyzProductUrlGenerator();
    }
}
