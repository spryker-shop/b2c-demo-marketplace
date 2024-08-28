<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Zed\FileUpload\Persistence\Propel\Mapper;

use Generated\Shared\Transfer\FileUploadTransfer;
use Orm\Zed\FileUpload\Persistence\PyzFileUpload;

class FileUploadMapper
{
    public function mapTransferToEntity(FileUploadTransfer $fileUploadTransfer, PyzFileUpload $pyzFileUpload): PyzFileUpload
    {
        return $pyzFileUpload->fromArray($fileUploadTransfer->toArray());
    }

    public function mapEntityToTransfer(
        PyzFileUpload $pyzFileUpload,
        FileUploadTransfer $fileUploadTransfer,
    ): FileUploadTransfer {
        return $fileUploadTransfer->fromArray($pyzFileUpload->toArray(), true);
    }
}
