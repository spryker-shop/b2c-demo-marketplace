<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductApprovalGui\Communication;

use \Pyz\Zed\ProductApprovalGui\Dependency\Facade\ProductApprovalGuiToProductApprovalFacadeBridge;

use Spryker\Zed\ProductApprovalGui\Communication\ProductApprovalGuiCommunicationFactory as SprykerProductApprovalGuiCommunicationFactory;
use Spryker\Zed\ProductApprovalGui\Dependency\Facade\ProductApprovalGuiToProductApprovalFacadeInterface;

/**
 * @method \Pyz\Zed\ProductApprovalGui\ProductApprovalGuiConfig getConfig()
 */
class ProductApprovalGuiCommunicationFactory extends SprykerProductApprovalGuiCommunicationFactory
{
    /**
     * @return \Spryker\Zed\ProductApprovalGui\Dependency\Facade\ProductApprovalGuiToProductApprovalFacadeInterface
     */
    public function getProductApprovalFacade(): ProductApprovalGuiToProductApprovalFacadeInterface
    {
        return new ProductApprovalGuiToProductApprovalFacadeBridge($this->getConfig());
    }
}
