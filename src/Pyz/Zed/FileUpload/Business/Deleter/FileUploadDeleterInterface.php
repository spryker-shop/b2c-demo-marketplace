<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\FileUpload\Business\Deleter;

use Generated\Shared\Transfer\FileUploadTransfer;

interface FileUploadDeleterInterface
{
    public function deleteFileUpload(FileUploadTransfer $fileUploadTransfer): bool;
}
