<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductMerchantPortalGui\Communication\Generator;

use Spryker\Zed\ProductMerchantPortalGui\Communication\Generator\CreateProductUrlGenerator as SprykerCreateProductUrlGenerator;

class CreateProductUrlGenerator extends SprykerCreateProductUrlGenerator
{
    /**
     * @uses \Spryker\Shared\ProductApproval\ProductApprovalConfig::STATUS_WAITING_FOR_APPROVAL
     *
     * @var string
     */
    protected const PYZ_STATUS_WAITING_FOR_APPROVAL = 'waiting_for_approval';

    /**
     * @uses \Spryker\Shared\ProductApproval\ProductApprovalConfig::STATUS_DRAFT
     *
     * @var string
     */
    protected const PYZ_STATUS_DRAFT = 'draft';

    /**
     * @param string $status
     * @param int $idProductAbstract
     *
     * @return string
     */
    public function getUpdateProductAbstractApprovalStatusUrl(string $status, int $idProductAbstract): string
    {
        $getParams = '';
        if ($status === static::PYZ_STATUS_DRAFT) {
            $getParams = http_build_query(
                [
                    static::FIELD_APPROVAL_STATUS => static::PYZ_STATUS_WAITING_FOR_APPROVAL,
                    static::FIELD_ID_PRODUCT_ABSTRACT => $idProductAbstract,
                ],
            );
        }

        if ($status === static::PYZ_STATUS_WAITING_FOR_APPROVAL) {
            $getParams = http_build_query(
                [
                    static::FIELD_APPROVAL_STATUS => static::PYZ_STATUS_DRAFT,
                    static::FIELD_ID_PRODUCT_ABSTRACT => $idProductAbstract,
                ],
            );
        }

        if (!$getParams) {
            return parent::getUpdateProductAbstractApprovalStatusUrl($status, $idProductAbstract);
        }

        return sprintf(
            '%s?%s',
            static::URL_UPDATE_APPROVAL_STATUS,
            $getParams,
        );
    }
}
