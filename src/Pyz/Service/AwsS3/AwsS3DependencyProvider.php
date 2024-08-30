<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Service\AwsS3;

use Pyz\Service\AwsS3\Dependency\S3ClientProviderPluginInterface;
use Pyz\Service\AwsS3\Plugin\AwsS3\S3ClientProviderPlugin;
use Spryker\Service\Kernel\AbstractBundleDependencyProvider;
use Spryker\Service\Kernel\Container;

/**
 * @method \Pyz\Service\AwsS3\AwsS3Config getConfig()
 */
class AwsS3DependencyProvider extends AbstractBundleDependencyProvider
{
    public const PLUGIN_S3_CLIENT_PROVIDER = 'PLUGIN_S3_CLIENT_PROVIDER_PLUGIN';

    public function provideServiceDependencies(Container $container): Container
    {
        $container = parent::provideServiceDependencies($container);
        $container = $this->addS3ClientProviderPlugin($container);

        return $container;
    }

    private function addS3ClientProviderPlugin(Container $container): Container
    {
        $container->set(
            static::PLUGIN_S3_CLIENT_PROVIDER,
            static function (): S3ClientProviderPluginInterface {
                return new S3ClientProviderPlugin();
            },
        );

        return $container;
    }
}
