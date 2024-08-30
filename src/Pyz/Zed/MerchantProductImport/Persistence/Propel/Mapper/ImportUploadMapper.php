<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\MerchantProductImport\Persistence\Propel\Mapper;

use Generated\Shared\Transfer\FileUploadTransfer;
use Generated\Shared\Transfer\ImportUploadCollectionTransfer;
use Generated\Shared\Transfer\ImportUploadTransfer;
use Generated\Shared\Transfer\MerchantTransfer;
use Generated\Shared\Transfer\UserTransfer;
use Orm\Zed\FileUpload\Persistence\PyzFileUpload;
use Orm\Zed\Merchant\Persistence\SpyMerchant;
use Orm\Zed\MerchantProductImport\Persistence\PyzImportUpload;
use Orm\Zed\User\Persistence\SpyUser;
use Propel\Runtime\Collection\ObjectCollection;

class ImportUploadMapper
{
    /**
     * @param \Orm\Zed\MerchantProductImport\Persistence\PyzImportUpload $pyzImportUploadEntity
     *
     * @return \Generated\Shared\Transfer\ImportUploadTransfer
     */
    public function mapImportUploadEntityToImportUploadTransfer(PyzImportUpload $pyzImportUploadEntity): ImportUploadTransfer
    {
        return (new ImportUploadTransfer())
            ->fromArray($pyzImportUploadEntity->toArray(), true)
            ->setFileUpload($this->mapFileUploadEntityToTransfer($pyzImportUploadEntity->getPyzFileUpload()));

    }

    /**
     * @param \Generated\Shared\Transfer\ImportUploadTransfer $importUploadTransfer
     *
     * @return \Orm\Zed\MerchantProductImport\Persistence\PyzImportUpload
     */
    public function mapImportUploadTransferToImportUploadEntity(ImportUploadTransfer $importUploadTransfer): PyzImportUpload
    {
        $pyzImportUploadEntity = (new PyzImportUpload())
            ->fromArray($importUploadTransfer->toArray())
            ->setFkFileUpload($importUploadTransfer->getFileUpload()->getIdFileUpload());

        $pyzImportUploadEntity->setNew($importUploadTransfer->getIdImportUpload() ? false : true);

        return $pyzImportUploadEntity;
    }

    /**
     * @param \Orm\Zed\Merchant\Persistence\SpyMerchant $spyMerchantEntity
     *
     * @return \Generated\Shared\Transfer\MerchantTransfer
     */
    private function mapMerchantEntityToMerchantTransfer(SpyMerchant $spyMerchantEntity): MerchantTransfer
    {
        return (new MerchantTransfer())
            ->fromArray($spyMerchantEntity->toArray(), true);
    }

    /**
     * @param \Orm\Zed\User\Persistence\SpyUser $spyUserEntity
     *
     * @return \Generated\Shared\Transfer\UserTransfer
     */
    private function mapUserEntityToUserTransfer(SpyUser $spyUserEntity): UserTransfer
    {
        return (new UserTransfer())
            ->fromArray($spyUserEntity->toArray(), true);
    }

    /**
     * @param \Propel\Runtime\Collection\ObjectCollection $pyzImportUploadEntityCollection
     *
     * @return \Generated\Shared\Transfer\ImportUploadCollectionTransfer
     */
    public function mapImportUploadEntityCollectionToImportUploadCollectionTransfer(
        ObjectCollection $pyzImportUploadEntityCollection,
    ): ImportUploadCollectionTransfer {
        $importUploadCollectionTransfer = new ImportUploadCollectionTransfer();

        foreach ($pyzImportUploadEntityCollection as $pyzImportUploadEntity) {
            $importUploadCollectionTransfer->addImportUpload(
                $this->mapImportUploadEntityToImportUploadTransfer($pyzImportUploadEntity),
            );
        }

        return $importUploadCollectionTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ImportUploadCollectionTransfer $importUploadCollectionTransfer
     *
     * @return \Propel\Runtime\Collection\ObjectCollection<\Orm\Zed\MerchantProductImport\Persistence\Base\PyzImportUpload>
     */
    public function mapImportUploadCollectionTransferToImportUploadEntityCollection(
        ImportUploadCollectionTransfer $importUploadCollectionTransfer,
    ): ObjectCollection {
        $pyzImportUploadEntityCollection = new ObjectCollection();
        $pyzImportUploadEntityCollection->setModel(PyzImportUpload::class);

        foreach ($importUploadCollectionTransfer->getImportUploads() as $importUploadTransfer) {
            $pyzImportUploadEntityCollection->append(
                $this->mapImportUploadTransferToImportUploadEntity($importUploadTransfer),
            );
        }

        return $pyzImportUploadEntityCollection;
    }

    private function mapFileUploadEntityToTransfer(PyzFileUpload $fileUpload): FileUploadTransfer
    {
        return (new FileUploadTransfer())
            ->fromArray($fileUpload->toArray(), true);
    }
}
