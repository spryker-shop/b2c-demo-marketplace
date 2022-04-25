<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ExampleProductSalePage\Business\Label;

use Generated\Shared\Transfer\ProductLabelProductAbstractRelationsTransfer;
use Orm\Zed\ProductLabel\Persistence\SpyProductLabel;
use Pyz\Zed\ExampleProductSalePage\Business\Exception\ProductLabelSaleNotFoundException;
use Pyz\Zed\ExampleProductSalePage\ExampleProductSalePageConfig;
use Pyz\Zed\ExampleProductSalePage\Persistence\ExampleProductSalePageQueryContainerInterface;
use Spryker\Zed\Currency\Business\CurrencyFacadeInterface;
use Spryker\Zed\Price\Business\PriceFacadeInterface;

class ProductAbstractRelationReader implements ProductAbstractRelationReaderInterface
{
    /**
     * @var \Pyz\Zed\ExampleProductSalePage\Persistence\ExampleProductSalePageQueryContainerInterface
     */
    protected $productSaleQueryContainer;

    /**
     * @var \Pyz\Zed\ExampleProductSalePage\ExampleProductSalePageConfig
     */
    protected $productSaleConfig;

    /**
     * @var \Spryker\Zed\Currency\Business\CurrencyFacadeInterface
     */
    protected $currencyFacade;

    /**
     * @var \Spryker\Zed\Price\Business\PriceFacadeInterface
     */
    protected $priceFacade;

    /**
     * @param \Pyz\Zed\ExampleProductSalePage\Persistence\ExampleProductSalePageQueryContainerInterface $productSaleQueryContainer
     * @param \Pyz\Zed\ExampleProductSalePage\ExampleProductSalePageConfig $productSaleConfig
     * @param \Spryker\Zed\Currency\Business\CurrencyFacadeInterface $currencyFacade
     * @param \Spryker\Zed\Price\Business\PriceFacadeInterface $priceFacade
     */
    public function __construct(
        ExampleProductSalePageQueryContainerInterface $productSaleQueryContainer,
        ExampleProductSalePageConfig $productSaleConfig,
        CurrencyFacadeInterface $currencyFacade,
        PriceFacadeInterface $priceFacade
    ) {
        $this->productSaleQueryContainer = $productSaleQueryContainer;
        $this->productSaleConfig = $productSaleConfig;
        $this->currencyFacade = $currencyFacade;
        $this->priceFacade = $priceFacade;
    }

    /**
     * @return \Generated\Shared\Transfer\ProductLabelProductAbstractRelationsTransfer[]
     */
    public function findProductLabelProductAbstractRelationChanges()
    {
        $result = [];

        $productLabelNewEntity = $this->getProductLabelNewEntity();

        if (!$productLabelNewEntity->getIsActive()) {
            return [];
        }

        $relationsToDeAssign = $this->findRelationsBecomingInactive($productLabelNewEntity);
        $relationsToAssign = $this->findRelationsBecomingActive($productLabelNewEntity);

        $idProductLabels = array_keys($relationsToDeAssign) + array_keys($relationsToAssign);

        foreach ($idProductLabels as $idProductLabel) {
            $result[] = $this->mapRelationTransfer($idProductLabel, $relationsToAssign, $relationsToDeAssign);
        }

        return $result;
    }

    /**
     * @throws \Pyz\Zed\ExampleProductSalePage\Business\Exception\ProductLabelSaleNotFoundException
     *
     * @return \Orm\Zed\ProductLabel\Persistence\SpyProductLabel
     */
    protected function getProductLabelNewEntity()
    {
        $labelNewName = $this->productSaleConfig->getPyzLabelSaleName();
        $productLabelNewEntity = $this->productSaleQueryContainer
            ->queryPyzProductLabelByName($labelNewName)
            ->findOne();

        if (!$productLabelNewEntity) {
            throw new ProductLabelSaleNotFoundException(sprintf(
                'Product Label "%1$s" doesn\'t exists. You can fix this problem by persisting a new Product Label entity into your database with "%1$s" name.',
                $labelNewName
            ));
        }

        return $productLabelNewEntity;
    }

    /**
     * @param \Orm\Zed\ProductLabel\Persistence\SpyProductLabel $productLabelEntity
     *
     * @return array
     */
    protected function findRelationsBecomingInactive(SpyProductLabel $productLabelEntity)
    {
        $relations = [];

        $productLabelProductAbstractEntities = $this->productSaleQueryContainer
            ->queryPyzRelationsBecomingInactive(
                $productLabelEntity->getIdProductLabel(),
                $this->priceFacade->getDefaultPriceMode(),
            )
            ->find();

        foreach ($productLabelProductAbstractEntities as $productLabelProductAbstractEntity) {
            $relations[$productLabelEntity->getIdProductLabel()][] = $productLabelProductAbstractEntity->getFkProductAbstract();
        }

        return $relations;
    }

    /**
     * @param \Orm\Zed\ProductLabel\Persistence\SpyProductLabel $productLabelEntity
     *
     * @return array
     */
    protected function findRelationsBecomingActive(SpyProductLabel $productLabelEntity)
    {
        $relations = [];

        $productAbstractEntities = $this->productSaleQueryContainer
            ->queryPyzRelationsBecomingActive(
                $productLabelEntity->getIdProductLabel(),
                $this->currencyFacade->getCurrentStoreWithCurrencies()->getStore()->getIdStore(),
                $this->currencyFacade->getDefaultCurrencyForCurrentStore()->getIdCurrency(),
                $this->priceFacade->getDefaultPriceMode(),
            )
            ->find();

        foreach ($productAbstractEntities as $productAbstractEntity) {
            $relations[$productLabelEntity->getIdProductLabel()][] = $productAbstractEntity->getIdProductAbstract();
        }

        return $relations;
    }

    /**
     * @param int $idProductLabel
     * @param array $relationsToAssign
     * @param array $relationsToDeAssign
     *
     * @return \Generated\Shared\Transfer\ProductLabelProductAbstractRelationsTransfer
     */
    protected function mapRelationTransfer($idProductLabel, array $relationsToAssign, array $relationsToDeAssign)
    {
        $productLabelProductAbstractRelationsTransfer = new ProductLabelProductAbstractRelationsTransfer();
        $productLabelProductAbstractRelationsTransfer->setIdProductLabel($idProductLabel);

        if (!empty($relationsToAssign[$idProductLabel])) {
            $productLabelProductAbstractRelationsTransfer->setIdsProductAbstractToAssign($relationsToAssign[$idProductLabel]);
        }

        if (!empty($relationsToDeAssign[$idProductLabel])) {
            $productLabelProductAbstractRelationsTransfer->setIdsProductAbstractToDeAssign($relationsToDeAssign[$idProductLabel]);
        }

        return $productLabelProductAbstractRelationsTransfer;
    }
}
