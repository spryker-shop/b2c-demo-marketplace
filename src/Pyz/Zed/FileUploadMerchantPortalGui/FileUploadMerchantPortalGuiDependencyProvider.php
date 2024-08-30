<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Zed\FileUploadMerchantPortalGui;

use Pyz\Service\AwsS3\AwsS3ServiceInterface;
use Pyz\Zed\FileUpload\Business\FileUploadFacadeInterface;
use Spryker\Shared\GuiTable\GuiTableFactoryInterface;
use Spryker\Shared\GuiTable\Http\GuiTableDataRequestExecutorInterface;
use Spryker\Shared\ZedUi\ZedUiFactoryInterface;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\MerchantUser\Business\MerchantUserFacadeInterface;

class FileUploadMerchantPortalGuiDependencyProvider extends AbstractBundleDependencyProvider
{
    public const FACADE_MERCHANT_USER = 'FACADE_MERCHANT_USER';

    public const FACADE_FILE_UPLOAD = 'FACADE_FILE_UPLOAD';

    public const SERVICE_AWS_S3 = 'SERVICE_AWS_S3';

    public const GUI_TABLE_DATA_REQUEST_EXECUTOR = 'GUI_TABLE_DATA_REQUEST_EXECUTOR';

    public const ZED_UI_FACTORY = 'ZED_UI_FACTORY';

    public const GUI_TABLE_FACTORY = 'GUI_TABLE_FACTORY';

    /**
     * @uses \Spryker\Zed\GuiTable\Communication\Plugin\Application\GuiTableApplicationPlugin::SERVICE_GUI_TABLE_HTTP_DATA_REQUEST_EXECUTOR
     *
     * @var string
     */
    private const APPLICATION_SERVICE_GUI_TABLE_HTTP_DATA_REQUEST_EXECUTOR = 'gui_table_http_data_request_executor';

    /**
     * @uses \Spryker\Zed\ZedUi\Communication\Plugin\Application\ZedUiApplicationPlugin::SERVICE_ZED_UI_FACTORY
     *
     * @var string
     */
    private const APPLICATION_SERVICE_ZED_UI_FACTORY = 'SERVICE_ZED_UI_FACTORY';

    /**
     * @uses \Spryker\Zed\GuiTable\Communication\Plugin\Application\GuiTableApplicationPlugin::SERVICE_GUI_TABLE_FACTORY
     *
     * @var string
     */
    private const APPLICATION_SERVICE_GUI_TABLE_FACTORY = 'gui_table_factory';

    public function provideCommunicationLayerDependencies(Container $container): Container
    {
        $container = parent::provideCommunicationLayerDependencies($container);

        $this->addMerchantUserFacade($container);
        $this->addFileUploadFacade($container);
        $this->addGuiTableDataRequestExecutor($container);
        $this->addGuiTableFactory($container);
        $this->addZedUiFactory($container);
        $this->addAwsS3Service($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return void
     */
    private function addGuiTableDataRequestExecutor(Container $container): void
    {
        $container->set(
            self::GUI_TABLE_DATA_REQUEST_EXECUTOR,
            static function (Container $container): GuiTableDataRequestExecutorInterface {
                return $container->getApplicationService(self::APPLICATION_SERVICE_GUI_TABLE_HTTP_DATA_REQUEST_EXECUTOR);
            },
        );
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return void
     */
    private function addMerchantUserFacade(Container $container): void
    {
        $container->set(
            self::FACADE_MERCHANT_USER,
            static function (Container $container): MerchantUserFacadeInterface {
                return $container->getLocator()->merchantUser()->facade();
            },
        );
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return void
     */
    private function addAwsS3Service(Container $container): void
    {
        $container->set(
            self::SERVICE_AWS_S3,
            static function (Container $container): AwsS3ServiceInterface {
                return $container->getLocator()->awsS3()->service();
            },
        );
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return void
     */
    private function addFileUploadFacade(Container $container): void
    {
        $container->set(
            self::FACADE_FILE_UPLOAD,
            static function (Container $container): FileUploadFacadeInterface {
                return $container->getLocator()->fileUpload()->facade();
            },
        );
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return void
     */
    private function addZedUiFactory(Container $container): void
    {
        $container->set(
            self::ZED_UI_FACTORY,
            static function (Container $container): ZedUiFactoryInterface {
                return $container->getApplicationService(self::APPLICATION_SERVICE_ZED_UI_FACTORY);
            },
        );
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return void
     */
    private function addGuiTableFactory(Container $container): void
    {
        $container->set(
            self::GUI_TABLE_FACTORY,
            static function (Container $container): GuiTableFactoryInterface {
                return $container->getApplicationService(self::APPLICATION_SERVICE_GUI_TABLE_FACTORY);
            },
        );
    }
}
