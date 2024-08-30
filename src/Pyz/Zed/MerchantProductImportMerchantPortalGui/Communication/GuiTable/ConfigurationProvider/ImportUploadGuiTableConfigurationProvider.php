<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\MerchantProductImportMerchantPortalGui\Communication\GuiTable\ConfigurationProvider;

use Generated\Shared\Transfer\GuiTableConfigurationTransfer;
use Pyz\Zed\MerchantProductImportMerchantPortalGui\MerchantProductImportMerchantPortalGuiConfig;
use Spryker\Shared\GuiTable\Configuration\Builder\GuiTableConfigurationBuilderInterface;
use Spryker\Shared\GuiTable\GuiTableFactoryInterface;

class ImportUploadGuiTableConfigurationProvider implements ImportUploadGuiTableConfigurationProviderInterface
{
    public const COL_ID_OWNER = 'owner';

    public const COL_ID_ORIGINAL_FILE_NAME = 'originalFileName';

    public const COL_ID_UPLOAD_TIME = 'uploadTime';

    public const COL_ID_PROCESSING_START_TIME = 'processingStartTime';

    public const COL_ID_PROCESSING_FINISH_TIME = 'processingFinishTime';

    public const COL_ID_TOTAL_NUMBER_OF_PRODUCTS = 'totalNumberOfProducts';

    public const COL_ID_NUMBER_OF_PRODUCTS_UPLOADED = 'numberOfProductsUploaded';

    public const COL_ID_NUMBER_OF_PRODUCTS_FAILED = 'numberOfProductsFailed';

    public const COL_ID_STATUS = 'status';

    public const COL_ID_STATUS_UPDATED_TIME = 'statusUpdatedTime';

    public const COL_ID_ERRORS = 'errors';

    private const FILTER_ID_STATUS = 'status';

    private const TITLE_FILTER_STATUS = 'Status';

    private const TITLE_COLUMN_OWNER = 'Owner';

    private const TITLE_COLUMN_UPLOAD_TIME = 'Upload Time';

    private const TITLE_COLUMN_PROCESSING_START_TIME = 'Processing Start Time';

    private const TITLE_COLUMN_PROCESSING_FINISH_TIME = 'Processing Finish Time';

    private const TITLE_COLUMN_TOTAL_NUMBER_OF_PRODUCTS = 'Total Number of Products';

    private const TITLE_COLUMN_NUMBER_OF_PRODUCTS_UPLOADED = 'Number of Products Uploaded';

    private const TITLE_COLUMN_NUMBER_OF_PRODUCTS_FAILED = 'Number of Products Failed';

    private const TITLE_COLUMN_ORIGINAL_FILE_NAME = 'File Name';

    private const TITLE_COLUMN_STATUS = 'Status';

    private const TITLE_COLUMN_STATUS_UPDATED_TIME = 'Status Updated Time';

    private const TITLE_COLUMN_ERRORS = 'Errors';

    private const COLOR_GREY = 'gray';

    private const DATA_URL = '/merchant-product-import-merchant-portal-gui/imports/table-data';

    private GuiTableFactoryInterface $guiTableFactory;

    private MerchantProductImportMerchantPortalGuiConfig $config;

    public function __construct(
        GuiTableFactoryInterface $guiTableFactory,
        MerchantProductImportMerchantPortalGuiConfig $config,
    ) {
        $this->guiTableFactory = $guiTableFactory;
        $this->config = $config;
    }

    public function getConfiguration(): GuiTableConfigurationTransfer
    {
        $guiTableConfigurationBuilder = $this->guiTableFactory->createConfigurationBuilder()
            ->setDataSourceUrl(self::DATA_URL)
            ->isSearchEnabled(false);

        $guiTableConfigurationBuilder = $this->addColumns($guiTableConfigurationBuilder);
        $guiTableConfigurationBuilder = $this->addFilters($guiTableConfigurationBuilder);

        return $guiTableConfigurationBuilder->createConfiguration();
    }

    private function addColumns(
        GuiTableConfigurationBuilderInterface $guiTableConfigurationBuilder,
    ): GuiTableConfigurationBuilderInterface {
        $guiTableConfigurationBuilder
            ->addColumnText(self::COL_ID_OWNER, self::TITLE_COLUMN_OWNER, false, false)
            ->addColumnText(self::COL_ID_ORIGINAL_FILE_NAME, self::TITLE_COLUMN_ORIGINAL_FILE_NAME, false, false)
            ->addColumnText(self::COL_ID_UPLOAD_TIME, self::TITLE_COLUMN_UPLOAD_TIME, false, false)
            ->addColumnText(self::COL_ID_PROCESSING_START_TIME, self::TITLE_COLUMN_PROCESSING_START_TIME, false, false)
            ->addColumnText(self::COL_ID_PROCESSING_FINISH_TIME, self::TITLE_COLUMN_PROCESSING_FINISH_TIME, false, false)
            ->addColumnText(self::COL_ID_TOTAL_NUMBER_OF_PRODUCTS, self::TITLE_COLUMN_TOTAL_NUMBER_OF_PRODUCTS, false, false)
            ->addColumnText(self::COL_ID_NUMBER_OF_PRODUCTS_UPLOADED, self::TITLE_COLUMN_NUMBER_OF_PRODUCTS_UPLOADED, false, false)
            ->addColumnText(self::COL_ID_NUMBER_OF_PRODUCTS_FAILED, self::TITLE_COLUMN_NUMBER_OF_PRODUCTS_FAILED, false, false)
            ->addColumnChip(self::COL_ID_STATUS, self::TITLE_COLUMN_STATUS, false, false, self::COLOR_GREY, $this->config->getStatusChipColorMapping())
            ->addColumnText(self::COL_ID_STATUS_UPDATED_TIME, self::TITLE_COLUMN_STATUS_UPDATED_TIME, false, false)
            ->addColumnText(self::COL_ID_ERRORS, self::TITLE_COLUMN_ERRORS, false, false, 1, 'gray');

        return $guiTableConfigurationBuilder;
    }

    private function addFilters(
        GuiTableConfigurationBuilderInterface $guiTableConfigurationBuilder,
    ): GuiTableConfigurationBuilderInterface {
        $guiTableConfigurationBuilder->addFilterSelect(
            self::FILTER_ID_STATUS,
            self::TITLE_FILTER_STATUS,
            false,
            $this->config->getStatusEnumValueToLabelMap(),
        );

        return $guiTableConfigurationBuilder;
    }
}
