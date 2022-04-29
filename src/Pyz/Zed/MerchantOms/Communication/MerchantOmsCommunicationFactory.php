<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\MerchantOms\Communication;

use Pyz\Zed\MerchantOms\MerchantOmsDependencyProvider;
use Pyz\Zed\Oms\Business\OmsFacadeInterface;
use Spryker\Zed\MerchantOms\Communication\MerchantOmsCommunicationFactory as SprykerMerchantOmsCommunicationFactory;
use Spryker\Zed\SalesReturn\Business\SalesReturnFacadeInterface;

/**
 * @method \Pyz\Zed\MerchantOms\MerchantOmsConfig getConfig()
 * @method \Spryker\Zed\MerchantOms\Business\MerchantOmsFacadeInterface getFacade()
 * @method \Spryker\Zed\MerchantOms\Persistence\MerchantOmsRepositoryInterface getRepository()
 */
class MerchantOmsCommunicationFactory extends SprykerMerchantOmsCommunicationFactory
{
    /**
     * @return \Pyz\Zed\Oms\Business\OmsFacadeInterface
     */
    public function getPyzOmsFacade(): OmsFacadeInterface
    {
        return $this->getProvidedDependency(MerchantOmsDependencyProvider::PYZ_FACADE_OMS);
    }

    /**
     * @return \Spryker\Zed\SalesReturn\Business\SalesReturnFacadeInterface
     */
    public function getPyzSalesReturnFacade(): SalesReturnFacadeInterface
    {
        return $this->getProvidedDependency(MerchantOmsDependencyProvider::PYZ_FACADE_SALES_RETURN);
    }
}
