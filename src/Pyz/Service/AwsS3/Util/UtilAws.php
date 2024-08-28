<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Service\AwsS3\Util;

use Aws\S3\S3ClientInterface;

class UtilAws implements UtilAwsInterface
{
    private S3ClientInterface $s3Client;

    public function __construct(S3ClientInterface $s3Client)
    {
        $this->s3Client = $s3Client;
    }

    /**
     * @return void
     */
    public function registerStreamWrapper(): void
    {
        $this->s3Client->registerStreamWrapper();
    }
}
