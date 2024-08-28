<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Zed\FileUpload;

use Pyz\Service\AwsS3\AwsS3ServiceInterface;
use Pyz\Zed\MerchantProductImport\Communication\Plugin\FileUpload\MerchantProductImpostPostSavePlugin;
use Spryker\Zed\Merchant\Business\MerchantFacadeInterface;
use Spryker\Zed\User\Business\UserFacadeInterface;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\MerchantUser\Business\MerchantUserFacadeInterface;

class FileUploadDependencyProvider extends AbstractBundleDependencyProvider
{
    public const FACADE_MERCHANT_USER = 'FACADE_MERCHANT_USER';

    public const FACADE_MERCHANT = 'FACADE_MERCHANT';

    public const FACADE_USER = 'FACADE_USER';

    public const SERVICE_AWS_S3 = 'SERVICE_AWS_S3';

    public const PLUGINS_FILE_UPLOAD_POST_SAVE = 'PLUGINS_FILE_UPLOAD_POST_SAVE';

    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);

        $this->addMerchantUserFacade($container);
        $this->addAwsS3Service($container);
        $this->addFileUploadPostSavePlugins($container);

        return $container;
    }

    public function provideCommunicationLayerDependencies(Container $container): Container
    {
        $container = parent::provideCommunicationLayerDependencies($container);

        $this->addUserFacade($container);
        $this->addMerchantFacade($container);
        $this->addAwsS3Service($container);

        return $container;
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
    private function addMerchantFacade(Container $container): void
    {
        $container->set(
            self::FACADE_MERCHANT,
            static function (Container $container): MerchantFacadeInterface {
                return $container->getLocator()->merchant()->facade();
            },
        );
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return void
     */
    private function addUserFacade(Container $container): void
    {
        $container->set(
            self::FACADE_USER,
            static function (Container $container): UserFacadeInterface {
                return $container->getLocator()->user()->facade();
            },
        );
    }

    private function addFileUploadPostSavePlugins(Container $container): void
    {
        $container->set(
            self::PLUGINS_FILE_UPLOAD_POST_SAVE,
            function (): array {
                return $this->getFileUploadPostSavePlugins();
            }
        );
    }

    /**
     * @return array<\Pyz\Zed\FileUpload\Dependency\Plugin\FileUploadPostSavePluginInterface>
     */
    private function getFileUploadPostSavePlugins(): array
    {
        return [
            new MerchantProductImpostPostSavePlugin(),
        ];
    }
}
