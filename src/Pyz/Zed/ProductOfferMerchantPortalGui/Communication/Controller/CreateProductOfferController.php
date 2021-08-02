<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductOfferMerchantPortalGui\Communication\Controller;

use Generated\Shared\Transfer\ProductAbstractTransfer;
use Generated\Shared\Transfer\ProductConcreteTransfer;
use Spryker\Zed\ProductOfferMerchantPortalGui\Communication\Controller\CreateProductOfferController as SprykerCreateProductOfferController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class CreateProductOfferController extends SprykerCreateProductOfferController
{
    /**
     * @todo Temporary fix, should be removed before demoshop release.
     *
     * @phpstan-param \Symfony\Component\Form\FormInterface<mixed> $productOfferForm
     *
     * @param \Symfony\Component\Form\FormInterface $productOfferForm
     * @param \Generated\Shared\Transfer\ProductConcreteTransfer $productConcreteTransfer
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     * @param mixed[] $initialData
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    protected function getResponse(
        FormInterface $productOfferForm,
        ProductConcreteTransfer $productConcreteTransfer,
        ProductAbstractTransfer $productAbstractTransfer,
        array $initialData
    ): JsonResponse {
        $localeTransfer = $this->getFactory()
            ->getLocaleFacade()
            ->getCurrentLocale();
        $priceProductOfferTableConfiguration = $this->getFactory()
            ->createPriceProductOfferCreateGuiTableConfigurationProvider()
            ->getConfiguration($initialData);
        $isPriceProductOffersValid = count($initialData['errors']) === 0;

        $responseData = [
            'form' => $this->renderView('@ProductOfferMerchantPortalGui/Partials/offer_form.twig', [
                'form' => $productOfferForm->createView(),
                'product' => $productConcreteTransfer,
                'productName' => $this->getFactory()->createProductNameBuilder()->buildProductConcreteName($productConcreteTransfer, $localeTransfer),
                'productAttributes' => $this->getProductAttributes($localeTransfer, $productConcreteTransfer, $productAbstractTransfer),
                'priceProductOfferTableConfiguration' => $priceProductOfferTableConfiguration,
            ])->getContent(),
        ];

        if (!$productOfferForm->isSubmitted()) {
            return new JsonResponse($responseData);
        }

        if ($productOfferForm->isValid() && $isPriceProductOffersValid) {
            $this->addSuccessMessage('The Offer is saved.');

            $responseData = $this->addSuccessResponseDataToResponse($responseData);

            return new JsonResponse($responseData);
        }

        $responseData = $this->addErrorResponseDataToResponse($responseData);

        return new JsonResponse($responseData);
    }
}
