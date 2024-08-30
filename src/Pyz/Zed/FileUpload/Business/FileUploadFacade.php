<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Zed\FileUpload\Business;

use Generated\Shared\Transfer\FileUploadCriteriaTransfer;
use Generated\Shared\Transfer\FileUploadTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \Pyz\Zed\FileUpload\Business\FileUploadBusinessFactory getFactory()
 * @method \Pyz\Zed\FileUpload\Persistence\FileUploadEntityManagerInterface getEntityManager()
 * @method \Pyz\Zed\FileUpload\Persistence\FileUploadRepositoryInterface getRepository()
 */
class FileUploadFacade extends AbstractFacade implements FileUploadFacadeInterface
{
    public function findFileUpload(FileUploadCriteriaTransfer $fileUploadCriteriaTransfer): ?FileUploadTransfer
    {
        return $this->getFactory()
            ->createFileUploadReader()
            ->findFileUpload($fileUploadCriteriaTransfer);
    }

    public function createFileUpload(FileUploadTransfer $fileUploadTransfer): FileUploadTransfer
    {
        return $this->getFactory()
            ->createFileUploadWriter()
            ->createFileUpload($fileUploadTransfer);
    }

    public function deleteFileUpload(FileUploadTransfer $fileUploadTransfer): bool
    {
        return $this->getFactory()
            ->createFileUploadDeleter()
            ->deleteFileUpload($fileUploadTransfer);
    }

    public function buildUploadFileNameForCurrentMerchant(string $originalFileName, string $contentType): string
    {
        return $this->getFactory()
            ->createFileNameBuilder()
            ->buildUploadFileNameForCurrentMerchant($originalFileName, $contentType);
    }

    public function buildUploadFileNameForMerchant(string $originalFileName, string $contentType, string $merchantReference): string
    {
        return $this->getFactory()
            ->createFileNameBuilder()
            ->buildUploadFileNameForMerchant($originalFileName, $contentType, $merchantReference);
    }

    public function resolveFileTypeByContentType(string $fileContentType): string
    {
        return $this->getFactory()
            ->createFileTypeResolver()
            ->resolveFileTypeByContentType($fileContentType);
    }
}
