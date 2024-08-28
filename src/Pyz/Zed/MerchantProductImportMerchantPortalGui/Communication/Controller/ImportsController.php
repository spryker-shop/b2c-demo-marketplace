<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\MerchantProductImportMerchantPortalGui\Communication\Controller;

use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @method \Pyz\Zed\MerchantProductImportMerchantPortalGui\Communication\MerchantProductImportMerchantPortalGuiCommunicationFactory getFactory()
 * @method \Pyz\Zed\MerchantProductImportMerchantPortalGui\Persistence\MerchantProductImportMerchantPortalGuiRepositoryInterface getRepository()
 */
class ImportsController extends AbstractController
{
    /**
     * @var string
     */
    private const TABLE_ID_PRODUCT_IMPORT = 'product-import';

    /**
     * @return array<string, mixed>
     */
    public function indexAction(): array
    {
        $viewData = $this->prepareViewData();

        return $this->viewResponse($viewData);
    }

    public function tableDataAction(Request $request): Response
    {
        return $this->getFactory()->getGuiTableHttpDataRequestExecutor()->execute(
            $request,
            $this->getFactory()->createImportUploadGuiTableDataProvider(),
            $this->getFactory()->createImportUploadGuiTableConfigurationProvider()->getConfiguration(),
        );
    }

    /**
     * @SuppressWarnings(PHPMD.LongVariable)
     *
     * @return array<string, mixed>
     */
    private function prepareViewData(): array
    {
        $importUploadGuiTableConfigurationProvider = $this->getFactory()
            ->createImportUploadGuiTableConfigurationProvider();

        return [
            'idTableProductImport' => self::TABLE_ID_PRODUCT_IMPORT,
            'tableConfiguration' => $importUploadGuiTableConfigurationProvider->getConfiguration(),
        ];
    }
}
