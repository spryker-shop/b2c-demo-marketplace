<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\MerchantProductImportMerchantPortalGui;

use Spryker\Zed\Kernel\AbstractBundleConfig;

class MerchantProductImportMerchantPortalGuiConfig extends AbstractBundleConfig
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
     * @var string
     */
    public const LABEL_STATUS_PENDING = 'Pending';

    /**
     * @var string
     */
    public const LABEL_STATUS_IN_PROGRESS = 'In progress';

    /**
     * @var string
     */
    public const LABEL_STATUS_FAILED = 'Failed';

    /**
     * @var string
     */
    public const LABEL_STATUS_PARTIALLY_FAILED = 'Partially failed';

    /**
     * @var string
     */
    public const LABEL_STATUS_SUCCESSFUL = 'Successful';

    /**
     * @var array<string, string>
     */
    public const MAP_STATUS_ENUM_TO_LABEL = [
        self::STATUS_PENDING => self::LABEL_STATUS_PENDING,
        self::STATUS_IN_PROGRESS => self::LABEL_STATUS_IN_PROGRESS,
        self::STATUS_FAILED => self::LABEL_STATUS_FAILED,
        self::STATUS_PARTIALLY_FAILED => self::LABEL_STATUS_PARTIALLY_FAILED,
        self::STATUS_SUCCESSFUL => self::LABEL_STATUS_SUCCESSFUL,
    ];

    /**
     * @var array<string, string>
     */
    public const MAP_STATUS_CHIP_TO_COLOR = [
        self::LABEL_STATUS_PENDING => 'gray',
        self::LABEL_STATUS_IN_PROGRESS => 'blue',
        self::LABEL_STATUS_FAILED => 'red',
        self::LABEL_STATUS_PARTIALLY_FAILED => 'orange',
        self::LABEL_STATUS_SUCCESSFUL => 'green',
    ];

    /**
     * @return array<string, string>
     */
    public function getStatusEnumValueToLabelMap(): array
    {
        return self::MAP_STATUS_ENUM_TO_LABEL;
    }

    /**
     * @return array<string, string>
     */
    public function getStatusChipColorMapping(): array
    {
        return self::MAP_STATUS_CHIP_TO_COLOR;
    }
}
