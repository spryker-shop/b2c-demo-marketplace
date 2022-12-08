<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\PriceProductOfferDataImport;

use Generated\Shared\Transfer\DataImporterConfigurationTransfer;
use Spryker\Zed\PriceProductOfferDataImport\PriceProductOfferDataImportConfig as SprykerPriceProductOfferDataImportConfig;

class PriceProductOfferDataImportConfig extends SprykerPriceProductOfferDataImportConfig
{
    /**
     * @var string
     */
    public const PYZ_IMPORT_TYPE_COMBINED_PRICE_PRODUCT_OFFER = 'combined-price-product-offer';

    /**
     * @return \Generated\Shared\Transfer\DataImporterConfigurationTransfer
     */
    public function getPyzCombinedPriceProductOfferDataImporterConfiguration(): DataImporterConfigurationTransfer
    {
        $moduleDataImportDirectory = $this->getDataImportRootPath() . 'common' . DIRECTORY_SEPARATOR . 'common' . DIRECTORY_SEPARATOR;

        return $this->buildImporterConfiguration(
            $moduleDataImportDirectory . 'combined_merchant_product_offer.csv',
            static::PYZ_IMPORT_TYPE_COMBINED_PRICE_PRODUCT_OFFER
        );
    }
}
