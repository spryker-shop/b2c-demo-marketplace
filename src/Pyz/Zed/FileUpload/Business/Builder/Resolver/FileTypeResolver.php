<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Zed\FileUpload\Business\Builder\Resolver;

use Pyz\Zed\FileUpload\Business\Exception\FileUploadException;
use Pyz\Zed\FileUpload\FileUploadConfig;

class FileTypeResolver implements FileTypeResolverInterface
{
    private FileUploadConfig $config;

    public function __construct(FileUploadConfig $config)
    {
        $this->config = $config;
    }

    public function resolveFileTypeByContentType(string $fileContentType): string
    {
        foreach ($this->config->getAllowedFileContentMap() as $fileType => $allowedContentTypes) {
            if (in_array($fileContentType, $allowedContentTypes, true)) {
                return $fileType;
            }
        }

        throw new FileUploadException(sprintf('File content type %s is not supported.', $fileContentType));
    }
}
