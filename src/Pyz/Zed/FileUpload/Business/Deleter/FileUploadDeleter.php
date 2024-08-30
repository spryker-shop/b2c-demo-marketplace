<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\FileUpload\Business\Deleter;

use Generated\Shared\Transfer\FileUploadTransfer;
use Pyz\Zed\FileUpload\Persistence\FileUploadEntityManagerInterface;

class FileUploadDeleter implements FileUploadDeleterInterface
{
    private FileUploadEntityManagerInterface $entityManager;

    public function __construct(FileUploadEntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function deleteFileUpload(FileUploadTransfer $fileUploadTransfer): bool
    {
        return $this->entityManager->deleteFileUpload($fileUploadTransfer);
    }
}
