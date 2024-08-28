<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Service\AwsS3;

use Pyz\Shared\AwsS3\AwsS3Constants;
use Spryker\Service\Kernel\AbstractBundleConfig;

class AwsS3Config extends AbstractBundleConfig
{
    private const AWS_S3_URL_PATTERN = 's3://%s/%s';

    private const CDN_URL_PATTERN = '{schema}://{cdnHost}/{fileName}';

    public function getAwsS3UrlPattern(): string
    {
        return self::AWS_S3_URL_PATTERN;
    }

    public function getCdnUrlPattern(): string
    {
        return self::CDN_URL_PATTERN;
    }

    public function getClientConfigurationForObjectType(string $objectType): array
    {
        $bucketsConfigurationMap = $this->get(AwsS3Constants::BUCKETS_CONFIGURATION_MAP, []);

        return $bucketsConfigurationMap[$objectType] ?? [];
    }
}
