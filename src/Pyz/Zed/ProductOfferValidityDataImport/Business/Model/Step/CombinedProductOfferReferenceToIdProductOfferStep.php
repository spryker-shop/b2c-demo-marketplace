<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\ProductOfferValidityDataImport\Business\Model\Step;

use Pyz\Zed\ProductOfferValidityDataImport\Business\Model\DataSet\CombinedProductOfferValidityDataSetInterface;
use Spryker\Zed\ProductOfferValidityDataImport\Business\Step\ProductOfferReferenceToIdProductOfferStep;

class CombinedProductOfferReferenceToIdProductOfferStep extends ProductOfferReferenceToIdProductOfferStep
{
    protected const PRODUCT_OFFER_REFERENCE = CombinedProductOfferValidityDataSetInterface::PRODUCT_OFFER_REFERENCE;
}
