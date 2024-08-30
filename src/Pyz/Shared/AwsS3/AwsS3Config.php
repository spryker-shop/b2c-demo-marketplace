<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Shared\AwsS3;

use Spryker\Shared\Kernel\AbstractSharedConfig;

class AwsS3Config extends AbstractSharedConfig
{
    /**
     * Specification:
     * - Identifies S3 object to be handled as CSV import file.
     *
     * @var string
     */
    public const OBJECT_TYPE_CVS_IMPORT = 'cvs_import_file';

    /**
     * Specification:
     * - Identifies S3 object to be handled as additional media for upload.
     *
     * @var string
     */
    public const OBJECT_TYPE_ADDITIONAL_MEDIA = 'additional_media';

    public const CONFIG_PRE_SIGNED_URL_EXPIRATION = 'preSignedUrlExpiration';

    public const CONFIG_CDN_HOST = 'cdnHost';
}
