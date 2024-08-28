<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Zed\FileUpload\Business\Builder;

use DateTime;
use Pyz\Zed\FileUpload\Business\Builder\Resolver\FileTypeResolverInterface;
use Pyz\Zed\FileUpload\Business\Exception\FileUploadException;
use Pyz\Zed\FileUpload\FileUploadConfig;
use Spryker\Zed\MerchantUser\Business\MerchantUserFacadeInterface;

class FileNameBuilder implements FileNameBuilderInterface
{
    private FileTypeResolverInterface $fileNamePatternResolver;

    private MerchantUserFacadeInterface $merchantUserFacade;

    private FileUploadConfig $config;

    public function __construct(
        FileTypeResolverInterface $fileNamePatternResolver,
        MerchantUserFacadeInterface $merchantUserFacade,
        FileUploadConfig $config,
    ) {
        $this->fileNamePatternResolver = $fileNamePatternResolver;
        $this->merchantUserFacade = $merchantUserFacade;
        $this->config = $config;
    }

    public function buildUploadFileNameForCurrentMerchant(string $originalFileName, string $contentType): string
    {
        return $this->buildUploadFileNameForMerchant(
            $originalFileName,
            $contentType,
            $this->getCurrentUserMerchantReference(),
        );
    }

    public function buildUploadFileNameForMerchant(
        string $originalFileName,
        string $contentType,
        string $merchantReference,
    ): string {
        $fileType = $this->fileNamePatternResolver->resolveFileTypeByContentType($contentType);
        $uploadFileNamePattern = $this->getFileNamePattern($fileType);

        return $this->buildFileNameForPattern(
            $uploadFileNamePattern,
            $originalFileName,
            $merchantReference,
        );
    }

    private function getFileNamePattern(string $fileType): string
    {
        $pattern = $this->config->getFileTypeNamePattern($fileType);
        if ($pattern) {
            return $pattern;
        }

        throw new FileUploadException(sprintf('File name pattern for %s not found.', $fileType));
    }

    private function buildFileNameForPattern(
        string $fileNamePattern,
        string $originalFileName,
        string $merchantReference,
    ): string {
        $fileNameParts = explode('.', $originalFileName);
        $extension = array_pop($fileNameParts);
        $fileNameWithoutExtension = implode('.', $fileNameParts);
        $fileNameWithoutExtension = $this->sanitizeFileName($fileNameWithoutExtension);

        return strtr(
            $fileNamePattern,
            [
                    '{merchant_reference}' => $merchantReference,
                    '{timestamp}' => $this->getCurrentTimestamp(),
                    '{file_name}' => $fileNameWithoutExtension,
                    '{extension}' => $extension,
                ],
        );
    }

    private function sanitizeFileName(string $fileName): string
    {
        $fileName = iconv('UTF-8', 'ASCII//TRANSLIT', $fileName);
        $fileName = preg_replace('/[\s-]+/', '-', $fileName);
        $fileName = preg_replace('/[^A-Za-z0-9\-_.]/', '', $fileName);
        $fileName = strtolower($fileName);
        $fileName = trim($fileName, '-');

        return $fileName;
    }

    private function getCurrentTimestamp(): string
    {
        return (new DateTime())->format(FileUploadConfig::TIMESTAMP_FORMAT);
    }

    private function getCurrentUserMerchantReference(): string
    {
        return $this->merchantUserFacade
            ->getCurrentMerchantUser()
            ->getMerchant()
            ->getMerchantReference();
    }
}
