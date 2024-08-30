<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Service\AwsS3\Creator;

interface UrlCreatorInterface
{
    /**
     * @param string $fileName
     *
     * @return string
     */
    public function getPresignedUrl(string $fileName): string;

    public function getCdnUrl(string $fileName): string;
}
