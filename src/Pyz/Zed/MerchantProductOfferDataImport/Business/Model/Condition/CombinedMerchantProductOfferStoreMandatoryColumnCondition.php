<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\MerchantProductOfferDataImport\Business\Model\Condition;

use Pyz\Zed\DataImport\Business\CombinedProduct\DataSet\CombinedProductMandatoryColumnCondition;
use Pyz\Zed\MerchantProductOfferDataImport\Business\Model\DataSet\CombinedMerchantProductOfferDataSetInterface;

class CombinedMerchantProductOfferStoreMandatoryColumnCondition extends CombinedProductMandatoryColumnCondition
{
    /**
     * @return array<string>
     */
    protected function getMandatoryColumns(): array
    {
        return [
            CombinedMerchantProductOfferDataSetInterface::STORE_NAME,
        ];
    }
}
