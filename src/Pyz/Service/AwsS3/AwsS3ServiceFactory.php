<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Service\AwsS3;

use Aws\S3\S3Client;
use Aws\S3\S3ClientInterface;
use Pyz\Service\AwsS3\Creator\UrlCreator;
use Pyz\Service\AwsS3\Creator\UrlCreatorInterface;
use Pyz\Service\AwsS3\Deleter\AwsS3ObjectDeleter;
use Pyz\Service\AwsS3\Deleter\AwsS3ObjectDeleterInterface;
use Pyz\Service\AwsS3\Dependency\S3ClientProviderPluginInterface;
use Pyz\Service\AwsS3\Reader\AwsS3ObjectReader;
use Pyz\Service\AwsS3\Reader\AwsS3ObjectReaderInterface;
use Pyz\Service\AwsS3\Util\UtilAws;
use Pyz\Service\AwsS3\Util\UtilAwsInterface;
use Spryker\Service\Kernel\AbstractServiceFactory;

/**
 * @method \Pyz\Service\AwsS3\AwsS3Config getConfig()
 */
class AwsS3ServiceFactory extends AbstractServiceFactory
{
    public function createUrlCreator(string $objectType): UrlCreatorInterface
    {
        $s3Client = $this
            ->getS3ClientProviderPlugin()
            ->provideConfiguredClientForObjectType($objectType);

        return new UrlCreator(
            $this->getConfig(),
            $s3Client,
            $objectType,
        );
    }

    public function createAwsS3ObjectReader(string $objectType): AwsS3ObjectReaderInterface
    {
        return new AwsS3ObjectReader($this->getConfig(), $objectType);
    }

    public function createAwsS3ObjectDeleter(string $objectType): AwsS3ObjectDeleterInterface
    {
        return new AwsS3ObjectDeleter(
            $this->createUtilAws($objectType),
        );
    }

    public function createUtilAws(string $objectType): UtilAwsInterface
    {
        $s3Client = $this
            ->getS3ClientProviderPlugin()
            ->provideConfiguredClientForObjectType($objectType);

        return new UtilAws($s3Client);
    }

    public function createS3Client(array $configuration): S3ClientInterface
    {
        return new S3Client($configuration);
    }

    public function getS3ClientProviderPlugin(): S3ClientProviderPluginInterface
    {
        return $this->getProvidedDependency(AwsS3DependencyProvider::PLUGIN_S3_CLIENT_PROVIDER);
    }
}
