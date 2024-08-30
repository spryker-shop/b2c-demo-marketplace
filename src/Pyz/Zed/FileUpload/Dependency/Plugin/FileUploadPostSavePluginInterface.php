<?php

declare(strict_types=1);

namespace Pyz\Zed\FileUpload\Dependency\Plugin;

use Generated\Shared\Transfer\FileUploadTransfer;

interface FileUploadPostSavePluginInterface
{
    /**
     * Specification:
     * - This plugin is executed after the file upload entity is saved.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\FileUploadTransfer $fileUploadTransfer
     *
     * @return void
     */
    public function execute(FileUploadTransfer $fileUploadTransfer): void;
}
