<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Zed\FileUpload\Business\Writer;

use Generated\Shared\Transfer\FileUploadTransfer;

interface FileUploadWriterInterface
{
    public function createFileUpload(FileUploadTransfer $fileUploadTransfer): FileUploadTransfer;
}
