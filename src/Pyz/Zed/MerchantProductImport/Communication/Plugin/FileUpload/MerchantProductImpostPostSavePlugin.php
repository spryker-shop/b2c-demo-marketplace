<?php

declare(strict_types=1);

namespace Pyz\Zed\MerchantProductImport\Communication\Plugin\FileUpload;

use Generated\Shared\Transfer\FileUploadTransfer;
use Pyz\Zed\FileUpload\Dependency\Plugin\FileUploadPostSavePluginInterface;
use Pyz\Zed\FileUpload\FileUploadConfig;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \Pyz\Zed\MerchantProductImport\Business\MerchantProductImportFacadeInterface getFacade()
 * @method \Pyz\Zed\MerchantProductImport\MerchantProductImportConfig getConfig()
 */
class MerchantProductImpostPostSavePlugin extends AbstractPlugin implements FileUploadPostSavePluginInterface
{
    /**
     * @see FileUploadConfig::FILE_TYPE_IMPORT_CSV
     *
     * @var string
     */
    private const FILE_TYPE_IMPORT_CSV = 'cvs_import_file';

    public function execute(FileUploadTransfer $fileUploadTransfer): void
    {
        if ($fileUploadTransfer->getObjectType() !== self::FILE_TYPE_IMPORT_CSV) {
            return;
        }

        $this->getFacade()->createImportUpload($fileUploadTransfer);
    }
}
