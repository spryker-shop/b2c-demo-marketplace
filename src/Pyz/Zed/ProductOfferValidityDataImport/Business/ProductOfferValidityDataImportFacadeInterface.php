<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\ProductOfferValidityDataImport\Business;

use Generated\Shared\Transfer\DataImporterConfigurationTransfer;
use Generated\Shared\Transfer\DataImporterReportTransfer;
use Spryker\Zed\ProductOfferValidityDataImport\Business\ProductOfferValidityDataImportFacadeInterface as SprykerProductOfferValidityDataImportFacadeInterface;

interface ProductOfferValidityDataImportFacadeInterface extends SprykerProductOfferValidityDataImportFacadeInterface
{
    public function importCombinedProductOfferValidity(
        ?DataImporterConfigurationTransfer $dataImporterConfigurationTransfer = null,
    ): DataImporterReportTransfer;
}
