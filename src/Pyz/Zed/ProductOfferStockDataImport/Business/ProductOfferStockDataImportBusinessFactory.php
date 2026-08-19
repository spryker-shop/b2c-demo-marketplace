<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\ProductOfferStockDataImport\Business;

use Generated\Shared\Transfer\DataImporterConfigurationTransfer;
use Pyz\Zed\DataImport\Business\Model\DataImporterConditional;
use Pyz\Zed\DataImport\Business\Model\DataSet\DataSetConditionInterface;
use Pyz\Zed\ProductOfferStockDataImport\Business\Model\Condition\CombinedProductOfferStockMandatoryColumnCondition;
use Pyz\Zed\ProductOfferStockDataImport\Business\Model\Step\CombinedProductOfferReferenceToIdProductOfferStep;
use Pyz\Zed\ProductOfferStockDataImport\Business\Model\Step\CombinedProductOfferStockWriterStep;
use Pyz\Zed\ProductOfferStockDataImport\Business\Model\Step\CombinedStockNameToIdStockStep;
use Spryker\Zed\DataImport\Business\Model\DataImporterInterface;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface;
use Spryker\Zed\DataImport\Business\Model\DataReader\DataReaderInterface;
use Spryker\Zed\ProductOfferStockDataImport\Business\ProductOfferStockDataImportBusinessFactory as SprykerProductOfferStockDataImportBusinessFactory;

/**
 * @method \Pyz\Zed\ProductOfferStockDataImport\ProductOfferStockDataImportConfig getConfig()
 */
class ProductOfferStockDataImportBusinessFactory extends SprykerProductOfferStockDataImportBusinessFactory
{
    public function getCombinedProductOfferStockDataImporter(): DataImporterInterface
    {
        $dataImporter = $this->getConditionalCsvDataImporterFromConfig(
            $this->getConfig()->getCombinedProductOfferStockDataImporterConfiguration(),
        );

        $dataSetStepBroker = $this->createTransactionAwareDataSetStepBroker();
        $dataSetStepBroker
            ->addStep($this->createCombinedProductOfferReferenceToIdProductOfferStep())
            ->addStep($this->createCombinedStockNameToIdStockStep())
            ->addStep($this->createCombinedProductOfferStockWriterStep());

        $dataImporter
            ->setDataSetCondition($this->createCombinedProductOfferStockMandatoryColumnCondition())
            ->addDataSetStepBroker($dataSetStepBroker);

        return $dataImporter;
    }

    public function getConditionalCsvDataImporterFromConfig(
        DataImporterConfigurationTransfer $dataImporterConfigurationTransfer,
    ): DataImporterConditional {
        $csvReader = $this->createCsvReaderFromConfig($dataImporterConfigurationTransfer->getReaderConfiguration());

        return $this->createDataImporterConditional($dataImporterConfigurationTransfer->getImportType(), $csvReader);
    }

    public function createDataImporterConditional(
        string $importType,
        DataReaderInterface $reader,
    ): DataImporterConditional {
        return new DataImporterConditional($importType, $reader, $this->getGracefulRunnerFacade());
    }

    public function createCombinedProductOfferReferenceToIdProductOfferStep(): DataImportStepInterface
    {
        return new CombinedProductOfferReferenceToIdProductOfferStep(
            $this->getProductOfferFacade(),
        );
    }

    public function createCombinedStockNameToIdStockStep(): DataImportStepInterface
    {
        return new CombinedStockNameToIdStockStep();
    }

    public function createCombinedProductOfferStockWriterStep(): DataImportStepInterface
    {
        return new CombinedProductOfferStockWriterStep();
    }

    public function createCombinedProductOfferStockMandatoryColumnCondition(): DataSetConditionInterface
    {
        return new CombinedProductOfferStockMandatoryColumnCondition();
    }
}
