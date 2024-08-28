<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Service\AwsS3\Deleter;

interface AwsS3ObjectDeleterInterface
{
    public function deleteS3Object(string $path): void;
}
