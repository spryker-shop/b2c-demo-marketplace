<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Zed\FileUpload\Persistence;

use Generated\Shared\Transfer\FileUploadTransfer;
use Spryker\Zed\Kernel\Persistence\EntityManager\EntityManagerInterface;

interface FileUploadEntityManagerInterface extends EntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\FileUploadTransfer $fileUploadTransfer
     *
     * @return \Generated\Shared\Transfer\FileUploadTransfer
     */
    public function createFileUpload(FileUploadTransfer $fileUploadTransfer): FileUploadTransfer;

    public function deleteFileUpload(FileUploadTransfer $fileUploadTransfer): bool;
}
