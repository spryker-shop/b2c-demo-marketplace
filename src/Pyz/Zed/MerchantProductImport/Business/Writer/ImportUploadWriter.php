<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\MerchantProductImport\Business\Writer;

use DateTime;
use DateTimeInterface;
use Generated\Shared\Transfer\FileUploadTransfer;
use Generated\Shared\Transfer\ImportUploadCollectionTransfer;
use Generated\Shared\Transfer\ImportUploadResponseTransfer;
use Generated\Shared\Transfer\ImportUploadTransfer;
use Generated\Shared\Transfer\MerchantUserTransfer;
use Propel\Runtime\Exception\EntityNotFoundException;
use Pyz\Zed\MerchantProductImport\MerchantProductImportConfig;
use Pyz\Zed\MerchantProductImport\Persistence\MerchantProductImportEntityManagerInterface;
use RuntimeException;

class ImportUploadWriter implements ImportUploadWriterInterface
{
    private MerchantProductImportConfig $merchantImportUploadConfig;

    private MerchantProductImportEntityManagerInterface $merchantProductImportEntityManager;

    public function __construct(
        MerchantProductImportConfig $merchantImportUploadConfig,
        MerchantProductImportEntityManagerInterface $merchantProductImportEntityManager,
    ) {
        $this->merchantImportUploadConfig = $merchantImportUploadConfig;
        $this->merchantProductImportEntityManager = $merchantProductImportEntityManager;
    }

    public function createImportUpload(FileUploadTransfer $fileUploadTransfer): ImportUploadResponseTransfer
    {
        $importUploadTransfer = $this->createImportUploadTransfer($fileUploadTransfer);
        $importUploadResponseTransfer = (new ImportUploadResponseTransfer())->setIsSuccessful(true);

        $importUploadCollectionTransfer = $this->merchantProductImportEntityManager->saveImportUploadCollection(
            (new ImportUploadCollectionTransfer())->addImportUpload($importUploadTransfer),
        );

        if ($importUploadCollectionTransfer->getImportUploads()->count() === 0) {
            $importUploadResponseTransfer->setIsSuccessful(false);
            $importUploadResponseTransfer->setMessage('Failed to create import upload');
        }

        $importUploadResponseTransfer->setImportUpload($importUploadCollectionTransfer->getImportUploads()->offsetGet(0));

        return $importUploadResponseTransfer;
    }

    public function updateImportUpload(ImportUploadTransfer $importUploadTransfer): ImportUploadResponseTransfer
    {
        $importUploadResponseTransfer = (new ImportUploadResponseTransfer())->setIsSuccessful(true);

        if ($importUploadTransfer->getIdImportUpload() === null) {
            $importUploadResponseTransfer->setIsSuccessful(false);
            $importUploadResponseTransfer->setMessage('Upload ID is missing');

            return $importUploadResponseTransfer;
        }

        try {
            $this->merchantProductImportEntityManager->updateImportUpload($importUploadTransfer);
        } catch (EntityNotFoundException) {
            $importUploadResponseTransfer->setIsSuccessful(false);
            $importUploadResponseTransfer->setMessage('Failed to update import upload. Wrong ID provided.');

            return $importUploadResponseTransfer;
        }

        return $importUploadResponseTransfer->setImportUpload($importUploadTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\ImportUploadCollectionTransfer $importUploadCollectionTransfer
     * @param string $status
     *
     * @throws \RuntimeException
     *
     * @return \Generated\Shared\Transfer\ImportUploadCollectionTransfer
     */
    public function updateImportUploadsCollectionStatus(
        ImportUploadCollectionTransfer $importUploadCollectionTransfer,
        string $status,
    ): ImportUploadCollectionTransfer {
        if (!in_array($status, $this->merchantImportUploadConfig->getImportUploadStatues())) {
            throw new RuntimeException(sprintf("Merchant import upload status '%s' is not allowed.", $status));
        }

        foreach ($importUploadCollectionTransfer->getImportUploads() as $importUploadTransfer) {
            if ($importUploadTransfer->getStatus() === $status) {
                continue;
            }

            $currentTime = (new DateTime())->format(DateTimeInterface::ATOM);
            $importUploadTransfer
                ->setStatus($status)
                ->setStartedAt($currentTime)
                ->setStatusUpdatedAt($currentTime);
        }

        return $this->merchantProductImportEntityManager->saveImportUploadCollection($importUploadCollectionTransfer);
    }

    private function createImportUploadTransfer(
        FileUploadTransfer $fileUploadTransfer,
    ): ImportUploadTransfer {
        return (new ImportUploadTransfer())
            ->setFileUpload($fileUploadTransfer)
            ->setFkMerchant($fileUploadTransfer->getFkMerchant())
            ->setFkUser($fileUploadTransfer->getFkUser())
            ->setStatus(MerchantProductImportConfig::STATUS_PENDING)
            ->setCreatedAt((new DateTime())->format(DateTimeInterface::ATOM));
    }
}
