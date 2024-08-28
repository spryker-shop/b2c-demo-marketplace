<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\MerchantProductImportMerchantPortalGui\Communication;

use Pyz\Zed\MerchantProductImportMerchantPortalGui\Communication\GuiTable\ConfigurationProvider\ImportUploadGuiTableConfigurationProvider;
use Pyz\Zed\MerchantProductImportMerchantPortalGui\Communication\GuiTable\ConfigurationProvider\ImportUploadGuiTableConfigurationProviderInterface;
use Pyz\Zed\MerchantProductImportMerchantPortalGui\Communication\GuiTable\DataProvider\ImportUploadGuiTableDataProvider;
use Pyz\Zed\MerchantProductImportMerchantPortalGui\MerchantProductImportMerchantPortalGuiDependencyProvider;
use Spryker\Shared\GuiTable\DataProvider\AbstractGuiTableDataProvider;
use Spryker\Shared\GuiTable\GuiTableFactoryInterface;
use Spryker\Shared\GuiTable\Http\GuiTableDataRequestExecutorInterface;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use Spryker\Zed\MerchantUser\Business\MerchantUserFacadeInterface;

/**
 * @method \Pyz\Zed\MerchantProductImportMerchantPortalGui\Persistence\MerchantProductImportMerchantPortalGuiRepositoryInterface getRepository()
 * @method \Pyz\Zed\MerchantProductImportMerchantPortalGui\MerchantProductImportMerchantPortalGuiConfig getConfig()
 */
class MerchantProductImportMerchantPortalGuiCommunicationFactory extends AbstractCommunicationFactory
{
    public function createImportUploadGuiTableConfigurationProvider(): ImportUploadGuiTableConfigurationProviderInterface
    {
        return new ImportUploadGuiTableConfigurationProvider(
            $this->getGuiTableFactory(),
            $this->getConfig(),
        );
    }

    public function createImportUploadGuiTableDataProvider(): AbstractGuiTableDataProvider
    {
        return new ImportUploadGuiTableDataProvider(
            $this->getRepository(),
            $this->getMerchantUserFacade(),
        );
    }

    public function getGuiTableFactory(): GuiTableFactoryInterface
    {
        return $this->getProvidedDependency(MerchantProductImportMerchantPortalGuiDependencyProvider::SERVICE_GUI_TABLE_FACTORY);
    }

    public function getGuiTableHttpDataRequestExecutor(): GuiTableDataRequestExecutorInterface
    {
        return $this->getProvidedDependency(MerchantProductImportMerchantPortalGuiDependencyProvider::SERVICE_GUI_TABLE_HTTP_DATA_REQUEST_EXECUTOR);
    }

    public function getMerchantUserFacade(): MerchantUserFacadeInterface
    {
        return $this->getProvidedDependency(MerchantProductImportMerchantPortalGuiDependencyProvider::FACADE_MERCHANT_USER);
    }
}
