<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\MerchantProductImport\Persistence;

use Generated\Shared\Transfer\ImportUploadCollectionTransfer;
use Generated\Shared\Transfer\ImportUploadTransfer;
use Propel\Runtime\Exception\EntityNotFoundException;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;

/**
 * @method \Pyz\Zed\MerchantProductImport\Persistence\MerchantProductImportPersistenceFactory getFactory()
 */
class MerchantProductImportEntityManager extends AbstractEntityManager implements MerchantProductImportEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\ImportUploadCollectionTransfer $importUploadCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\ImportUploadCollectionTransfer
     */
    public function saveImportUploadCollection(ImportUploadCollectionTransfer $importUploadCollectionTransfer): ImportUploadCollectionTransfer
    {
        $importUploadMapper = $this->getFactory()->createImportUploadMapper();

        $pyzImportUploadEntityCollection = $importUploadMapper->mapImportUploadCollectionTransferToImportUploadEntityCollection($importUploadCollectionTransfer);
        $pyzImportUploadEntityCollection->save();

        return $importUploadMapper->mapImportUploadEntityCollectionToImportUploadCollectionTransfer($pyzImportUploadEntityCollection);
    }

    /**
     * @param \Generated\Shared\Transfer\ImportUploadTransfer $importUploadTransfer
     *
     * @throws \Propel\Runtime\Exception\EntityNotFoundException
     *
     * @return void
     */
    public function updateImportUpload(ImportUploadTransfer $importUploadTransfer): void
    {
        $pyzImportUploadEntity = $this->getFactory()
            ->createImportUploadPropelQuery()
            ->filterByIdImportUpload($importUploadTransfer->getIdImportUpload())
            ->findOne();

        if (!$pyzImportUploadEntity) {
            throw new EntityNotFoundException(
                sprintf('Import upload entity with id "%s" not found', $importUploadTransfer->getIdImportUpload()),
            );
        }

        $pyzImportUploadEntity->fromArray($importUploadTransfer->modifiedToArray());

        $pyzImportUploadEntity->save();
    }
}
