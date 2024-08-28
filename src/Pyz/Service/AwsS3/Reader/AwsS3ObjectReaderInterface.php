<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Service\AwsS3\Reader;

interface AwsS3ObjectReaderInterface
{
    public function getS3ObjectUrl(string $fileName): string;
}
