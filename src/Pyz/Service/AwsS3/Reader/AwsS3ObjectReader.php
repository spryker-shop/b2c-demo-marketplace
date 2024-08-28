<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Service\AwsS3\Reader;

use Pyz\Service\AwsS3\AwsS3Config;

class AwsS3ObjectReader implements AwsS3ObjectReaderInterface
{
    private AwsS3Config $config;

    private string $objectType;

    public function __construct(AwsS3Config $config, string $objectType)
    {
        $this->config = $config;
        $this->objectType = $objectType;
    }

    public function getS3ObjectUrl(string $fileName): string
    {
        return sprintf($this->config->getAwsS3UrlPattern(), $this->getBucketName(), $fileName);
    }

    private function getBucketName(): string
    {
        $bucketConfiguration = $this->config->getClientConfigurationForObjectType($this->objectType);

        return $bucketConfiguration['Bucket'];
    }
}
