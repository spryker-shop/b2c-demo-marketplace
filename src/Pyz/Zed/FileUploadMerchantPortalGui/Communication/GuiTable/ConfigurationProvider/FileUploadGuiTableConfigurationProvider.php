<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Zed\FileUploadMerchantPortalGui\Communication\GuiTable\ConfigurationProvider;

use Generated\Shared\Transfer\FileUploadTransfer;
use Generated\Shared\Transfer\GuiTableConfigurationTransfer;
use Generated\Shared\Transfer\UserTransfer;
use Spryker\Shared\GuiTable\Configuration\Builder\GuiTableConfigurationBuilderInterface;
use Spryker\Shared\GuiTable\GuiTableFactoryInterface;

class FileUploadGuiTableConfigurationProvider implements FileUploadGuiTableConfigurationProviderInterface
{
    public const COL_USER_EMAIL = UserTransfer::EMAIL;

    public const COL_CDN_URL = FileUploadTransfer::CDN_URL;

    public const COL_CONTENT_TYPE = FileUploadTransfer::CONTENT_TYPE;

    public const COL_SIZE = FileUploadTransfer::SIZE;

    public const COL_CREATED_AT = FileUploadTransfer::CREATED_AT;

    private const ACTION_ID_DELETE = 'delete';

    private const ACTION_TITLE_DELETE = 'Delete';

    private const ACTION_CONFIRMATION_MODAL_TITLE = 'Delete file';

    private const ACTION_CONFIRMATION_MODAL_DESCRIPTION = 'Deleting this file might cause errors with associated products. Please remove the URL from products before deleting this file.';

    private const DATA_URL = '/file-upload-merchant-portal-gui/list/table-data';

    private const URL_DELETE = '/file-upload-merchant-portal-gui/delete?idFileUpload=${row.idFileUpload}';

    private const SEARCH_PLACEHOLDER = 'Search by URL';

    private GuiTableFactoryInterface $guiTableFactory;

    public function __construct(GuiTableFactoryInterface $guiTableFactory)
    {
        $this->guiTableFactory = $guiTableFactory;
    }

    public function getConfiguration(): GuiTableConfigurationTransfer
    {
        $guiTableConfigurationBuilder = $this->guiTableFactory->createConfigurationBuilder()
            ->setSearchPlaceholder(self::SEARCH_PLACEHOLDER)
            ->setDataSourceUrl(self::DATA_URL);

        $guiTableConfigurationBuilder = $this->addColumns($guiTableConfigurationBuilder);
        $guiTableConfigurationBuilder = $this->addRowActions($guiTableConfigurationBuilder);

        return $guiTableConfigurationBuilder->createConfiguration();
    }

    private function addColumns(
        GuiTableConfigurationBuilderInterface $guiTableConfigurationBuilder,
    ): GuiTableConfigurationBuilderInterface {
        $guiTableConfigurationBuilder
            ->addColumnText(self::COL_USER_EMAIL, 'User Reference', false, false)
            ->addColumnText(self::COL_CDN_URL, 'URL', false, false, null, null)
            ->addColumnText(self::COL_CONTENT_TYPE, 'Type', false, false)
            ->addColumnText(self::COL_SIZE, 'Size (kb)', false, false)
            ->addColumnText(self::COL_CREATED_AT, 'Uploaded time', false, false);

        return $guiTableConfigurationBuilder;
    }

    private function addRowActions(
        GuiTableConfigurationBuilderInterface $guiTableConfigurationBuilder,
    ): GuiTableConfigurationBuilderInterface {
        $guiTableConfigurationBuilder->addRowActionHttp(
            self::ACTION_ID_DELETE,
            self::ACTION_TITLE_DELETE,
            self::URL_DELETE
        );

        return $guiTableConfigurationBuilder;
    }
}
