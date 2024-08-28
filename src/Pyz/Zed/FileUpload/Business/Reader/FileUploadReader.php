<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Zed\FileUpload\Business\Reader;

use Generated\Shared\Transfer\FileUploadCriteriaTransfer;
use Generated\Shared\Transfer\FileUploadTransfer;
use Pyz\Zed\FileUpload\Persistence\FileUploadRepositoryInterface;

class FileUploadReader implements FileUploadReaderInterface
{
    private FileUploadRepositoryInterface $fileUploadRepository;

    public function __construct(FileUploadRepositoryInterface $fileUploadRepository)
    {
        $this->fileUploadRepository = $fileUploadRepository;
    }

    public function findFileUpload(FileUploadCriteriaTransfer $fileUploadCriteriaTransfer): ?FileUploadTransfer
    {
        return $this->fileUploadRepository->findFileUpload($fileUploadCriteriaTransfer);
    }
}
