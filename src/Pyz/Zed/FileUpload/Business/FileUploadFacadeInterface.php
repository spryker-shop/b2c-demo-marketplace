<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Zed\FileUpload\Business;

use Generated\Shared\Transfer\FileUploadCriteriaTransfer;
use Generated\Shared\Transfer\FileUploadTransfer;

interface FileUploadFacadeInterface
{
    public function findFileUpload(FileUploadCriteriaTransfer $fileUploadCriteriaTransfer): ?FileUploadTransfer;

    public function createFileUpload(FileUploadTransfer $fileUploadTransfer): FileUploadTransfer;

    public function deleteFileUpload(FileUploadTransfer $fileUploadTransfer): bool;

    public function buildUploadFileNameForCurrentMerchant(string $originalFileName, string $contentType): string;

    public function buildUploadFileNameForMerchant(
        string $originalFileName,
        string $contentType,
        string $merchantReference,
    ): string;

    public function resolveFileTypeByContentType(string $fileContentType): string;
}
