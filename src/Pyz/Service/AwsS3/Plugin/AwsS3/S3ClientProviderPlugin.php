<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Service\AwsS3\Plugin\AwsS3;

use Aws\S3\S3ClientInterface;
use Pyz\Service\AwsS3\Dependency\S3ClientProviderPluginInterface;
use Spryker\Service\Kernel\AbstractPlugin;

/**
 * @method \Pyz\Service\AwsS3\AwsS3ServiceInterface getService()
 * @method \Pyz\Service\AwsS3\AwsS3ServiceFactory getFactory()
 * @method \Pyz\Service\AwsS3\AwsS3Config getConfig()()
 */
class S3ClientProviderPlugin extends AbstractPlugin implements S3ClientProviderPluginInterface
{
    public function provideConfiguredClientForObjectType(string $objectType): S3ClientInterface
    {
        $configuration = $this->getConfig()->getClientConfigurationForObjectType($objectType);

        return $this->getFactory()->createS3Client($configuration);
    }
}
