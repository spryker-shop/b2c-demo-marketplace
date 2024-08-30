<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Zed\FileUpload\Business\Builder;

interface FileNameBuilderInterface
{
    public function buildUploadFileNameForCurrentMerchant(string $originalFileName, string $contentType): string;

    public function buildUploadFileNameForMerchant(
        string $originalFileName,
        string $contentType,
        string $merchantReference,
    ): string;
}
