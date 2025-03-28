<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\PriceProductOfferDataImport\Business\Model\Step;

use Pyz\Zed\PriceProductOfferDataImport\Business\Model\DataSet\CombinedPriceProductOfferDataSetInterface;
use Spryker\Zed\PriceProductOfferDataImport\Business\Step\PriceTypeToIdPriceTypeStep;

class CombinedPriceTypeToIdPriceTypeStep extends PriceTypeToIdPriceTypeStep
{
    protected const PRICE_TYPE = CombinedPriceProductOfferDataSetInterface::PRICE_TYPE;
}
