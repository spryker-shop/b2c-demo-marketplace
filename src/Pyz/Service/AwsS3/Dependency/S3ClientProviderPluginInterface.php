<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Service\AwsS3\Dependency;

use Aws\S3\S3ClientInterface;

interface S3ClientProviderPluginInterface
{
    public function provideConfiguredClientForObjectType(string $objectType): S3ClientInterface;
}
