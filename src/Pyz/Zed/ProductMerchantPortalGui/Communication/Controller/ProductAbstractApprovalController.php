<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductMerchantPortalGui\Communication\Controller;

use Spryker\Zed\ProductMerchantPortalGui\Communication\Controller\ProductAbstractApprovalController as SprykerProductAbstractApprovalController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Pyz\Zed\ProductMerchantPortalGui\Communication\ProductMerchantPortalGuiCommunicationFactory getFactory()
 * @method \Pyz\Zed\ProductMerchantPortalGui\ProductMerchantPortalGuiConfig getConfig()
 */
class ProductAbstractApprovalController extends SprykerProductAbstractApprovalController
{
    /**
     * @var string
     */
    protected const PYZ_PARAM_ID_PRODUCT_ABSTRACT = 'id-product-abstract';

    /**
     * @var string
     */
    protected const PYZ_PARAM_APPROVAL_STATUS = 'approval-status';

    /**
     * @var string
     */
    protected const PYZ_MESSAGE_PRODUCT_ABSTRACT_APPROVAL_STATUS_WAS_NOT_UPDATED = 'The approval status was not updated.';

    /**
     * @uses \Spryker\Shared\ProductApproval\ProductApprovalConfig::STATUS_DRAFT
     *
     * @var string
     */
    protected const PYZ_STATUS_DRAFT = 'draft';

    /**
     * @see \Spryker\Zed\ProductMerchantPortalGui\Communication\Controller\ProductsController::indexAction()
     *
     * @var string
     */
    protected const PYZ_URL_PRODUCTS = '/product-merchant-portal-gui/products';

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function indexAction(Request $request): RedirectResponse
    {
        $idProductAbstract = $this->castId($request->get(static::PYZ_PARAM_ID_PRODUCT_ABSTRACT));
        $approvalStatus = $request->get(static::PYZ_PARAM_APPROVAL_STATUS);

        $productAbstractTransfer = $this->getFactory()
            ->getProductFacade()
            ->findProductAbstractById($idProductAbstract);

        if (!$productAbstractTransfer) {
            $this->addErrorMessage('Abstract product was not found.');

            return $this->redirectResponse(static::PYZ_URL_PRODUCTS);
        }

        $applicableApprovalStatuses = $this->getFactory()->getConfig()->getPyzApplicableApprovalStatuses($productAbstractTransfer->getApprovalStatus() ?: static::PYZ_STATUS_DRAFT);

        if (!in_array($approvalStatus, $applicableApprovalStatuses, true)) {
            $this->addErrorMessage(static::PYZ_MESSAGE_PRODUCT_ABSTRACT_APPROVAL_STATUS_WAS_NOT_UPDATED);

            return $this->redirectResponse(static::PYZ_URL_PRODUCTS);
        }

        $productAbstractTransfer->setApprovalStatus($approvalStatus);

        $idProductAbstract = $this->getFactory()
            ->getProductFacade()
            ->saveProductAbstract($productAbstractTransfer);

        if (!$idProductAbstract) {
            $this->addErrorMessage(static::PYZ_MESSAGE_PRODUCT_ABSTRACT_APPROVAL_STATUS_WAS_NOT_UPDATED);

            return $this->redirectResponse(static::PYZ_URL_PRODUCTS);
        }

        $this->addSuccessMessage('The approval status was updated.');

        return $this->redirectResponse(static::PYZ_URL_PRODUCTS);
    }
}
