<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductMerchantPortalGui\Communication\Generator;

/**
 * @method \Pyz\Zed\ProductMerchantPortalGui\Communication\ProductMerchantPortalGuiCommunicationFactory getFactory()
 */
class CreatePyzProductUrlGenerator implements CreatePyzProductUrlGeneratorInterface
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
     * @uses \Spryker\Shared\ProductApproval\ProductApprovalConfig::FIELD_APPROVAL_STATUS
     *
     * @var string
     */
    protected const FIELD_APPROVAL_STATUS = 'approval-status';

    /**
     * @uses \Spryker\Shared\ProductApproval\ProductApprovalConfig::FIELD_ID_PRODUCT_ABSTRACT
     *
     * @var string
     */
    protected const FIELD_ID_PRODUCT_ABSTRACT = 'id-product-abstract';

    /**
     * @uses \Spryker\Shared\ProductApproval\ProductApprovalConfig::URL_UPDATE_APPROVAL_STATUS
     *
     * @var string
     */
    protected const URL_UPDATE_APPROVAL_STATUS = '/product-merchant-portal-gui/product-abstract-approval';

    /**
     * @param string $status
     * @param int $idProductAbstract
     *
     * @return string
     */
    public function getPyzUpdateProductAbstractApprovalStatusUrl(string $status, int $idProductAbstract): string
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
            $this->getFactory()->createCreateProductUrlGenerator()->getUpdateProductAbstractApprovalStatusUrl($status, $idProductAbstract);
        }

        return sprintf(
            '%s?%s',
            static::URL_UPDATE_APPROVAL_STATUS,
            $getParams,
        );
    }
}
