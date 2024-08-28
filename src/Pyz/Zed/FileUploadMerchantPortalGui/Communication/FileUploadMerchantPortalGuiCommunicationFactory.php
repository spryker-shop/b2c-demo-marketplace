<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Zed\FileUploadMerchantPortalGui\Communication;

use Pyz\Service\AwsS3\AwsS3ServiceInterface;
use Pyz\Zed\FileUpload\Business\FileUploadFacadeInterface;
use Pyz\Zed\FileUploadMerchantPortalGui\Communication\GuiTable\ConfigurationProvider\FileUploadGuiTableConfigurationProvider;
use Pyz\Zed\FileUploadMerchantPortalGui\Communication\GuiTable\ConfigurationProvider\FileUploadGuiTableConfigurationProviderInterface;
use Pyz\Zed\FileUploadMerchantPortalGui\Communication\GuiTable\DataProvider\FileUploadGuiTableDataProvider;
use Pyz\Zed\FileUploadMerchantPortalGui\FileUploadMerchantPortalGuiDependencyProvider;
use Spryker\Shared\GuiTable\DataProvider\GuiTableDataProviderInterface;
use Spryker\Shared\GuiTable\GuiTableFactoryInterface;
use Spryker\Shared\GuiTable\Http\GuiTableDataRequestExecutorInterface;
use Spryker\Shared\ZedUi\ZedUiFactoryInterface;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use Spryker\Zed\MerchantUser\Business\MerchantUserFacadeInterface;

/**
 * @method \Pyz\Zed\FileUploadMerchantPortalGui\Persistence\FileUploadMerchantPortalGuiRepositoryInterface getRepository()
 */
class FileUploadMerchantPortalGuiCommunicationFactory extends AbstractCommunicationFactory
{
    public function createFileUploadGuiTableConfigurationProvider(): FileUploadGuiTableConfigurationProviderInterface
    {
        return new FileUploadGuiTableConfigurationProvider($this->getGuiTableFactory());
    }

    public function createFileUploadGuiTableDataProvider(): GuiTableDataProviderInterface
    {
        return new FileUploadGuiTableDataProvider(
            $this->getMerchantUserFacade(),
            $this->getFileUploadFacade(),
            $this->getRepository(),
        );
    }

    public function getMerchantUserFacade(): MerchantUserFacadeInterface
    {
        return $this->getProvidedDependency(FileUploadMerchantPortalGuiDependencyProvider::FACADE_MERCHANT_USER);
    }

    public function getFileUploadFacade(): FileUploadFacadeInterface
    {
        return $this->getProvidedDependency(FileUploadMerchantPortalGuiDependencyProvider::FACADE_FILE_UPLOAD);
    }

    public function getAwsS3Service(): AwsS3ServiceInterface
    {
        return $this->getProvidedDependency(FileUploadMerchantPortalGuiDependencyProvider::SERVICE_AWS_S3);
    }

    public function getGuiTableDataRequestExecutor(): GuiTableDataRequestExecutorInterface
    {
        return $this->getProvidedDependency(FileUploadMerchantPortalGuiDependencyProvider::GUI_TABLE_DATA_REQUEST_EXECUTOR);
    }

    public function getZedUiFactory(): ZedUiFactoryInterface
    {
        return $this->getProvidedDependency(FileUploadMerchantPortalGuiDependencyProvider::ZED_UI_FACTORY);
    }

    public function getGuiTableFactory(): GuiTableFactoryInterface
    {
        return $this->getProvidedDependency(FileUploadMerchantPortalGuiDependencyProvider::GUI_TABLE_FACTORY);
    }
}
