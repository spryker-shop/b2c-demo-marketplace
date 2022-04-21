<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductMerchantPortalGui\Communication\Generator;

use Spryker\Zed\ProductMerchantPortalGui\Communication\Generator\CreateProductUrlGeneratorInterface as SprykerCreateProductUrlGeneratorInterface;

interface CreatePyzProductUrlGeneratorInterface extends SprykerCreateProductUrlGeneratorInterface
{
    /**
     * @param string $status
     * @param int $idProductAbstract
     *
     * @return string
     */
    public function getPyzUpdateProductAbstractApprovalStatusUrl(string $status, int $idProductAbstract): string;
}
