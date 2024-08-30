<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Zed\FileUploadMerchantPortalGui\Communication\Controller;

use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @method \Pyz\Zed\FileUploadMerchantPortalGui\Communication\FileUploadMerchantPortalGuiCommunicationFactory getFactory()
 * @method \Pyz\Zed\FileUploadMerchantPortalGui\Persistence\FileUploadMerchantPortalGuiRepositoryInterface getRepository()
 */
class ListController extends AbstractController
{
    /**
     * @return array
     */
    public function indexAction(): array
    {
        $tableConfigurationTransfer = $this->getFactory()
            ->createFileUploadGuiTableConfigurationProvider()
            ->getConfiguration();

        return $this->viewResponse([
            'tableConfiguration' => $tableConfigurationTransfer,
        ]);
    }

    public function tableDataAction(Request $request): Response
    {
        return $this->getFactory()->getGuiTableDataRequestExecutor()->execute(
            $request,
            $this->getFactory()->createFileUploadGuiTableDataProvider(),
            $this->getFactory()->createFileUploadGuiTableConfigurationProvider()->getConfiguration(),
        );
    }
}
