<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\MerchantProductImport;

use Pyz\Shared\MerchantProductImport\MerchantProductImportConstants;
use Spryker\Zed\Kernel\AbstractBundleConfig;

class MerchantProductImportConfig extends AbstractBundleConfig
{
    /**
     * @uses \Orm\Zed\MerchantProductImport\Persistence\Map\PyzImportUploadTableMap::COL_STATUS_PENDING
     *
     * @var string
     */
    public const STATUS_PENDING = 'pending';

    /**
     * @uses \Orm\Zed\MerchantProductImport\Persistence\Map\PyzImportUploadTableMap::COL_STATUS_IN_PROGRESS
     *
     * @var string
     */
    public const STATUS_IN_PROGRESS = 'in_progress';

    /**
     * @uses \Orm\Zed\MerchantProductImport\Persistence\Map\PyzImportUploadTableMap::COL_STATUS_FAILED
     *
     * @var string
     */
    public const STATUS_FAILED = 'failed';

    /**
     * @uses \Orm\Zed\MerchantProductImport\Persistence\Map\PyzImportUploadTableMap::COL_STATUS_PARTIALLY_FAILED
     *
     * @var string
     */
    public const STATUS_PARTIALLY_FAILED = 'partially_failed';

    /**
     * @uses \Orm\Zed\MerchantProductImport\Persistence\Map\PyzImportUploadTableMap::COL_STATUS_SUCCESSFUL
     *
     * @var string
     */
    public const STATUS_SUCCESSFUL = 'successful';

    /**
     * @return int
     */
    public function getImportUploadReadLimit(): int
    {
        return $this->get(MerchantProductImportConstants::IMPORT_UPLOAD_READ_LIMIT);
    }

    /**
     * @return array<string>
     */
    public function getImportUploadStatues(): array
    {
        return [
            self::STATUS_PENDING,
            self::STATUS_IN_PROGRESS,
            self::STATUS_FAILED,
            self::STATUS_PARTIALLY_FAILED,
            self::STATUS_SUCCESSFUL,
        ];
    }
}
