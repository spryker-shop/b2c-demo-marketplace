<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Service\AwsS3\Deleter;

use Pyz\Service\AwsS3\Util\UtilAwsInterface;

class AwsS3ObjectDeleter implements AwsS3ObjectDeleterInterface
{
    private UtilAwsInterface $utilAws;

    public function __construct(UtilAwsInterface $utilAws)
    {
        $this->utilAws = $utilAws;
    }

    public function deleteS3Object(string $path): void
    {
        $this->utilAws->registerStreamWrapper();

        unlink($path);
    }
}
