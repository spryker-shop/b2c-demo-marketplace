<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Zed\FileUpload\Persistence;

use Generated\Shared\Transfer\FileUploadCriteriaTransfer;
use Generated\Shared\Transfer\FileUploadTransfer;

interface FileUploadRepositoryInterface
{
    public function findFileUpload(FileUploadCriteriaTransfer $fileUploadCriteriaTransfer): ?FileUploadTransfer;
}
