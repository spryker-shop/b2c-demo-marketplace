<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductMerchantPortalGui\Communication\Controller;

use Generated\Shared\Transfer\ProductAbstractTransfer;
use Generated\Shared\Transfer\ValidationResponseTransfer;
use Spryker\Zed\ProductMerchantPortalGui\Communication\Controller\UpdateProductAbstractController as SprykerUpdateProductAbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @method \Pyz\Zed\ProductMerchantPortalGui\Communication\ProductMerchantPortalGuiCommunicationFactory getFactory()
 */
class UpdateProductAbstractController extends SprykerUpdateProductAbstractController
{
    /**
     * @param \Symfony\Component\Form\FormInterface $productAbstractForm
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     * @param \Generated\Shared\Transfer\ValidationResponseTransfer $validationResponseTransfer
     * @param array $priceInitialData
     * @param array $attributesInitialData
     * @param array $imageSetsErrors
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    protected function getResponse(
        FormInterface $productAbstractForm,
        ProductAbstractTransfer $productAbstractTransfer,
        ValidationResponseTransfer $validationResponseTransfer,
        array $priceInitialData,
        array $attributesInitialData,
        array $imageSetsErrors
    ): JsonResponse {
        $localeTransfer = $this->getFactory()
            ->getLocaleFacade()
            ->getCurrentLocale();

        $localizedAttributesTransfer = $this->getFactory()
            ->createLocalizedAttributesExtractor()
            ->extractLocalizedAttributes(
                $productAbstractTransfer->getLocalizedAttributes(),
                $localeTransfer,
            );

        $imageSetTabNames = $this->getImageSetTabNames($productAbstractTransfer);
        $imageSetsGroupedByIdLocale = $this->getImageSetsGroupedByIdLocale($productAbstractTransfer->getImageSets());
        $imageSetMetaData = $this->getImageSetMetaDataGroupedByImageSet($productAbstractTransfer->getImageSets(), $imageSetsErrors);

        $responseData = [
            'form' => $this->renderView(
                '@ProductMerchantPortalGui/Partials/product_abstract_form.twig',
                [
                    'productAbstract' => $productAbstractTransfer,
                    'imageSetTabNames' => $imageSetTabNames,
                    'imageSetsGroupedByIdLocale' => $imageSetsGroupedByIdLocale,
                    'imageSetMetaData' => $imageSetMetaData,
                    'productAbstractName' => $localizedAttributesTransfer ? $localizedAttributesTransfer->getName() : $productAbstractTransfer->getName(),
                    'form' => $productAbstractForm->createView(),
                    'priceProductAbstractTableConfiguration' => $this->getFactory()
                        ->createPriceProductAbstractGuiTableConfigurationProvider()
                        ->getConfiguration($productAbstractTransfer->getIdProductAbstractOrFail(), $priceInitialData),
                    'productAbstractAttributeTableConfiguration' => $this->getFactory()
                        ->createProductAbstractAttributeGuiTableConfigurationProvider()
                        ->getConfiguration($productAbstractTransfer->getIdProductAbstractOrFail(), $attributesInitialData),
                    'productConcreteTableConfiguration' => $this->getFactory()
                        ->createProductGuiTableConfigurationProvider()
                        ->getConfiguration($productAbstractTransfer->getIdProductAbstractOrFail()),
                    'productCategoryTree' => $this->getFactory()
                        ->createProductAbstractFormDataProvider()
                        ->getProductCategoryTree(),
                    'urlAddProductConcrete' => static::URL_ADD_PRODUCT_CONCRETE,
                    'urlUpdateApprovalStatus' => $this->getFactory()
                        ->createCreateProductUrlGenerator()
                        ->getUpdateProductAbstractApprovalStatusUrl($productAbstractTransfer->getApprovalStatus(), $productAbstractTransfer->getIdProductAbstractOrFail()),
                ],
            )->getContent(),
        ];

        if (!$productAbstractForm->isSubmitted()) {
            return new JsonResponse($responseData);
        }

        if ($productAbstractForm->isValid() && $validationResponseTransfer->getIsSuccess()) {
            $responseData = $this->addSuccessResponseDataToResponse($responseData);

            return new JsonResponse($responseData);
        }

        return new JsonResponse(
            $this->addErrorResponseDataToResponse(
                $productAbstractForm,
                $validationResponseTransfer,
                $responseData,
            ),
        );
    }
}
