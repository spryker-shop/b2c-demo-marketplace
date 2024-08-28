<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Zed\FileUpload\Business\Writer;

use Generated\Shared\Transfer\FileUploadTransfer;
use Pyz\Service\AwsS3\AwsS3ServiceInterface;
use Pyz\Service\AwsS3\Exception\S3BucketConfigurationNotFoundException;
use Pyz\Zed\FileUpload\Persistence\FileUploadEntityManagerInterface;
use Spryker\Zed\MerchantUser\Business\MerchantUserFacadeInterface;

class FileUploadWriter implements FileUploadWriterInterface
{
    private FileUploadEntityManagerInterface $entityManager;

    private MerchantUserFacadeInterface $merchantUserFacade;

    private AwsS3ServiceInterface $awsS3Service;

    /**
     * @return array<\Pyz\Zed\FileUpload\Dependency\Plugin\FileUploadPostSavePluginInterface>
     */
    private array $fileUploadPostSavePlugins;

    public function __construct(
        FileUploadEntityManagerInterface $entityManager,
        MerchantUserFacadeInterface $merchantUserFacade,
        AwsS3ServiceInterface $awsS3Service,
        array $fileUploadPostSavePlugins,
    ) {
        $this->entityManager = $entityManager;
        $this->merchantUserFacade = $merchantUserFacade;
        $this->awsS3Service = $awsS3Service;
        $this->fileUploadPostSavePlugins = $fileUploadPostSavePlugins;
    }

    public function createFileUpload(FileUploadTransfer $fileUploadTransfer): FileUploadTransfer
    {
        $fileUploadTransfer
            ->requireFileName()
            ->requireContentType()
            ->requireSize()
            ->requireOriginalFileName()
            ->requireObjectType();

        $this->setFileUploadOwner($fileUploadTransfer);
        $this->setFileUploadS3Url($fileUploadTransfer);
        $this->setFileUploadCdnUrl($fileUploadTransfer);

        $fileUploadTransfer = $this->entityManager->createFileUpload($fileUploadTransfer);

        $this->executePostSavePlugins($fileUploadTransfer);

        return $fileUploadTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\FileUploadTransfer $fileUploadTransfer
     *
     * @return void
     */
    private function setFileUploadCdnUrl(FileUploadTransfer $fileUploadTransfer): void
    {
        try {
            $cdnUrl = $this->awsS3Service->getCdnUrl(
                $fileUploadTransfer->getFileName(),
                $fileUploadTransfer->getObjectType(),
            );

            $fileUploadTransfer->setCdnUrl($cdnUrl);
        } catch (S3BucketConfigurationNotFoundException) {
            return;
        }
    }

    /**
     * @param \Generated\Shared\Transfer\FileUploadTransfer $fileUploadTransfer
     *
     * @return void
     */
    private function setFileUploadS3Url(FileUploadTransfer $fileUploadTransfer): void
    {
        $s3Url = $this->awsS3Service->getS3ObjectUrl(
            $fileUploadTransfer->getFileName(),
            $fileUploadTransfer->getObjectType(),
        );

        $fileUploadTransfer->setS3Url($s3Url);
    }

    /**
     * @param \Generated\Shared\Transfer\FileUploadTransfer $fileUploadTransfer
     *
     * @return void
     */
    private function setFileUploadOwner(FileUploadTransfer $fileUploadTransfer): void
    {
        if ($fileUploadTransfer->getFkUser() && $fileUploadTransfer->getFkMerchant()) {
            return;
        }

        $merchantUserTransfer = $this->merchantUserFacade->getCurrentMerchantUser();
        $fileUploadTransfer
            ->setFkMerchant($merchantUserTransfer->getIdMerchant())
            ->setFkUser($merchantUserTransfer->getIdUser());
    }

    private function executePostSavePlugins(FileUploadTransfer $fileUploadTransfer): void
    {
        foreach ($this->fileUploadPostSavePlugins as $fileUploadPostSavePlugin) {
            $fileUploadPostSavePlugin->execute($fileUploadTransfer);
        }
    }
}
