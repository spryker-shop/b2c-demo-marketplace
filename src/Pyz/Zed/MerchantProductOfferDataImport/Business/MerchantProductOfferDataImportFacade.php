<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\MerchantProductOfferDataImport\Business;

use Generated\Shared\Transfer\DataImporterConfigurationTransfer;
use Generated\Shared\Transfer\DataImporterReportTransfer;
use Spryker\Zed\MerchantProductOfferDataImport\Business\MerchantProductOfferDataImportFacade as SprykerMerchantProductOfferDataImportFacade;

/**
 * @method \Pyz\Zed\MerchantProductOfferDataImport\Business\MerchantProductOfferDataImportBusinessFactory getFactory()
 */
class MerchantProductOfferDataImportFacade extends SprykerMerchantProductOfferDataImportFacade implements MerchantProductOfferDataImportFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\DataImporterConfigurationTransfer|null $dataImporterConfigurationTransfer
     *
     * @return \Generated\Shared\Transfer\DataImporterReportTransfer
     */
    public function pyzImportCombinedMerchantProductOfferData(
        ?DataImporterConfigurationTransfer $dataImporterConfigurationTransfer = null
    ): DataImporterReportTransfer {
        return $this->getFactory()
            ->pyzGetCombinedMerchantProductOfferDataImporter()
            ->import($dataImporterConfigurationTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\DataImporterConfigurationTransfer|null $dataImporterConfigurationTransfer
     *
     * @return \Generated\Shared\Transfer\DataImporterReportTransfer
     */
    public function pyzImportCombinedMerchantProductOfferStoreData(
        ?DataImporterConfigurationTransfer $dataImporterConfigurationTransfer = null
    ): DataImporterReportTransfer {
        return $this->getFactory()
            ->pyzGetCombinedMerchantProductOfferStoreDataImporter()
            ->import($dataImporterConfigurationTransfer);
    }
}
