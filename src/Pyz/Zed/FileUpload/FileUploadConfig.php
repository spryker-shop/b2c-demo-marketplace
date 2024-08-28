<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Zed\FileUpload;

use Pyz\Shared\FileUpload\FileUploadConfig as SharedFileUploadConfig;
use Spryker\Zed\Kernel\AbstractBundleConfig;

class FileUploadConfig extends AbstractBundleConfig
{
    public const TIMESTAMP_FORMAT = 'Y-m-d-H-i-s';

    public const URL_GET_IMAGE_UPLOAD_URL = '/file-upload/upload/get-image-upload-url';

    public const IMAGE_FILE_NAME_PATTERN = '{merchant_reference}/images/{timestamp}_{file_name}.{extension}';

    public const VIDEO_FILE_NAME_PATTERN = '{merchant_reference}/video/{file_name}_{timestamp}.{extension}';

    public const DOCUMENT_FILE_NAME_PATTERN = '{merchant_reference}/document/{file_name}_{timestamp}.{extension}';

    /**
     * Specification:
     * - Defines allowed content types for each file type.
     *
     * @api
     *
     * @var array<string, array<string>>
     */
    private const ALLOWED_FILE_CONTENT_TYPE_MAP = [
        self::FILE_TYPE_IMAGE => SharedFileUploadConfig::ACCEPTED_IMAGE_CONTENT_TYPES,
        self::FILE_TYPE_VIDEO => SharedFileUploadConfig::ACCEPTED_VIDEO_CONTENT_TYPES,
        self::FILE_TYPE_DOCUMENT => SharedFileUploadConfig::ACCEPTED_DOCUMENT_CONTENT_TYPES,
    ];

    /**
     * Specification:
     * - Defines naming pattern for uploaded files by file type.
     *
     * @api
     *
     * @var array<string, string>
     */
    private const UPLOAD_FILE_NAME_PATTERN_MAP = [
        self::FILE_TYPE_IMAGE => self::IMAGE_FILE_NAME_PATTERN,
        self::FILE_TYPE_VIDEO => self::VIDEO_FILE_NAME_PATTERN,
        self::FILE_TYPE_DOCUMENT => self::DOCUMENT_FILE_NAME_PATTERN,
    ];

    private const FILE_TYPE_IMAGE = 'image';

    private const FILE_TYPE_VIDEO = 'video';

    private const FILE_TYPE_DOCUMENT = 'document';

    /**
     * @return array<string, array<string>>
     */
    public function getAllowedFileContentMap(): array
    {
        return self::ALLOWED_FILE_CONTENT_TYPE_MAP;
    }

    public function getFileTypeNamePattern(string $fileType): ?string
    {
        return self::UPLOAD_FILE_NAME_PATTERN_MAP[$fileType] ?? null;
    }
}
