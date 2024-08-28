<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Zed\FileUpload\Persistence;

use Generated\Shared\Transfer\FileUploadTransfer;
use Orm\Zed\FileUpload\Persistence\PyzFileUpload;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;

/**
 * @method \Pyz\Zed\FileUpload\Persistence\FileUploadPersistenceFactory getFactory()
 */
class FileUploadEntityManager extends AbstractEntityManager implements FileUploadEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\FileUploadTransfer $fileUploadTransfer
     *
     * @return void
     */
    public function createFileUpload(FileUploadTransfer $fileUploadTransfer): void
    {
        $pyzFileUpload = $this->getFactory()
            ->createFileUploadMapper()
            ->mapTransferToEntity($fileUploadTransfer, new PyzFileUpload());

        $pyzFileUpload->save();
    }

    public function deleteFileUpload(FileUploadTransfer $fileUploadTransfer): bool
    {
        $pyzFileUploadEntity = $this->getFactory()->createFileUploadQuery()
            ->filterByIdFileUpload($fileUploadTransfer->getIdFileUpload())
            ->findOne();

        if (!$pyzFileUploadEntity) {
            return false;
        }

        $pyzFileUploadEntity->delete();

        return true;
    }
}
