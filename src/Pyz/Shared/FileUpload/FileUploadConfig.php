<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Shared\FileUpload;

use Spryker\Shared\Kernel\AbstractSharedConfig;

class FileUploadConfig extends AbstractSharedConfig
{
    /**
     * Specification:
     * - Used directly in Twig template to provide list of acceptable content types for S3 file upload.
     *
     * @var array<string>
     */
    public const ACCEPTED_IMAGE_CONTENT_TYPES = ['image/png', 'image/jpeg', 'image/svg+xml'];

    /**
     * Specification:
     * - Used directly in Twig template to provide list of acceptable content types for S3 file upload.
     *
     * @var array<string>
     */
    public const ACCEPTED_VIDEO_CONTENT_TYPES = ['video/mp4', 'video/webm'];

    /**
     * Specification:
     * - Used directly in Twig template to provide list of acceptable content types for S3 file upload.
     *
     * @var array<string>
     */
    public const ACCEPTED_DOCUMENT_CONTENT_TYPES = [
        'application/pdf',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'application/vnd.ms-excel',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'text/plain',
    ];
}
