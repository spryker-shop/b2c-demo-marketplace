<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\MerchantProductOfferDataImport;

use Generated\Shared\Transfer\DataImporterConfigurationTransfer;
use Spryker\Zed\MerchantProductOfferDataImport\MerchantProductOfferDataImportConfig as SprykerMerchantProductOfferDataImportConfig;

class MerchantProductOfferDataImportConfig extends SprykerMerchantProductOfferDataImportConfig
{
    public const PYZ_IMPORT_TYPE_COMBINED_MERCHANT_PRODUCT_OFFER = 'combined-merchant-product-offer';
    public const PYZ_IMPORT_TYPE_COMBINED_MERCHANT_PRODUCT_OFFER_STORE = 'combined-merchant-product-offer-store';

    /**
     * @return \Generated\Shared\Transfer\DataImporterConfigurationTransfer
     */
    public function pyzGetCombinedMerchantProductOfferDataImporterConfiguration(): DataImporterConfigurationTransfer
    {
        return $this->buildImporterConfiguration(
            $this->pyzGetCombinedMerchantProductOfferFilePath(),
            static::PYZ_IMPORT_TYPE_COMBINED_MERCHANT_PRODUCT_OFFER
        );
    }

    /**
     * @return \Generated\Shared\Transfer\DataImporterConfigurationTransfer
     */
    public function pyzGetCombinedMerchantProductOfferStoreDataImporterConfiguration(): DataImporterConfigurationTransfer
    {
        return $this->buildImporterConfiguration(
            $this->pyzGetCombinedMerchantProductOfferFilePath(),
            static::PYZ_IMPORT_TYPE_COMBINED_MERCHANT_PRODUCT_OFFER_STORE
        );
    }

    /**
     * @return string
     */
    public function pyzGetCombinedMerchantProductOfferFilePath(): string
    {
        $moduleDataImportDirectory = $this->getDataImportRootPath() . 'common' . DIRECTORY_SEPARATOR . 'common' . DIRECTORY_SEPARATOR;

        return $moduleDataImportDirectory . 'combined_merchant_product_offer.csv';
    }
}
