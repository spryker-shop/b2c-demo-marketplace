<?php

namespace Pyz\Zed\ProductMerchantPortalGui\Communication\Generator;

use \Spryker\Zed\ProductMerchantPortalGui\Communication\Generator\CreateProductUrlGeneratorInterface as SprykerCreateProductUrlGeneratorInterface;

interface CreateProductUrlGeneratorInterface extends SprykerCreateProductUrlGeneratorInterface
{
    /**
     * @param string $status
     * @param int $idProductAbstract
     *
     * @return string
     */
    public function getPyzUpdateProductAbstractApprovalStatusUrl(string $status, int $idProductAbstract): string;
}
