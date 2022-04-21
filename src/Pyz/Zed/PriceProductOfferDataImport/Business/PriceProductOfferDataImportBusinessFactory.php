<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\PriceProductOfferDataImport\Business;

use Generated\Shared\Transfer\DataImporterConfigurationTransfer;
use Pyz\Zed\DataImport\Business\Model\DataImporterConditional;
use Pyz\Zed\DataImport\Business\Model\DataSet\DataSetConditionInterface;
use Pyz\Zed\PriceProductOfferDataImport\Business\Model\Condition\CombinedPriceProductOfferMandatoryColumnCondition;
use Pyz\Zed\PriceProductOfferDataImport\Business\Model\Step\CombinedCurrencyToIdCurrencyStep;
use Pyz\Zed\PriceProductOfferDataImport\Business\Model\Step\CombinedPreparePriceDataStep;
use Pyz\Zed\PriceProductOfferDataImport\Business\Model\Step\CombinedPriceProductStoreWriterStep;
use Pyz\Zed\PriceProductOfferDataImport\Business\Model\Step\CombinedPriceProductWriterStep;
use Pyz\Zed\PriceProductOfferDataImport\Business\Model\Step\CombinedPriceTypeToIdPriceTypeStep;
use Pyz\Zed\PriceProductOfferDataImport\Business\Model\Step\CombinedProductOfferReferenceToProductOfferDataStep;
use Pyz\Zed\PriceProductOfferDataImport\Business\Model\Step\CombinedProductOfferToIdProductStep;
use Pyz\Zed\PriceProductOfferDataImport\Business\Model\Step\CombinedStoreToIdStoreStep;
use Spryker\Zed\DataImport\Business\Model\DataImporterInterface;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface;
use Spryker\Zed\DataImport\Business\Model\DataReader\DataReaderInterface;
use Spryker\Zed\PriceProductOfferDataImport\Business\PriceProductOfferDataImportBusinessFactory as SprykerPriceProductOfferDataImportBusinessFactory;

/**
 * @method \Pyz\Zed\PriceProductOfferDataImport\PriceProductOfferDataImportConfig getConfig()
 */
class PriceProductOfferDataImportBusinessFactory extends SprykerPriceProductOfferDataImportBusinessFactory
{
    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataImporterInterface
     */
    public function getPyzCombinedPriceProductOfferDataImport(): DataImporterInterface
    {
        $dataImporter = $this->getPyzConditionalCsvDataImporterFromConfig(
            $this->getConfig()->getPyzCombinedPriceProductOfferDataImporterConfiguration()
        );

        $dataSetStepBroker = $this->createTransactionAwareDataSetStepBroker();
        $dataSetStepBroker
            ->addStep($this->createPyzCombinedProductOfferReferenceToProductOfferDataStep())
            ->addStep($this->createPyzCombinedProductOfferToIdProductStep())
            ->addStep($this->createPyzCombinedPriceTypeToIdPriceTypeStep())
            ->addStep($this->createPyzCombinedPriceProductWriterStep())
            ->addStep($this->createPyzCombinedStoreToIdStoreStep())
            ->addStep($this->createPyzCombinedCurrencyToIdCurrencyStep())
            ->addStep($this->createPyzCombinedPreparePriceDataStep())
            ->addStep($this->createPyzCombinedPriceProductStoreWriterStep())
            ->addStep($this->createPriceProductOfferWriterStep());

        $dataImporter
            ->setDataSetCondition($this->createPyzCombinedPriceProductOfferMandatoryColumnCondition())
            ->addDataSetStepBroker($dataSetStepBroker);

        return $dataImporter;
    }

    /**
     * @param \Generated\Shared\Transfer\DataImporterConfigurationTransfer $dataImporterConfigurationTransfer
     *
     * @return \Pyz\Zed\DataImport\Business\Model\DataImporterConditional
     */
    public function getPyzConditionalCsvDataImporterFromConfig(
        DataImporterConfigurationTransfer $dataImporterConfigurationTransfer
    ): DataImporterConditional {
        $csvReader = $this->createCsvReaderFromConfig($dataImporterConfigurationTransfer->getReaderConfiguration());

        return $this->createPyzDataImporterConditional($dataImporterConfigurationTransfer->getImportType(), $csvReader);
    }

    /**
     * @param string $importType
     * @param \Spryker\Zed\DataImport\Business\Model\DataReader\DataReaderInterface $reader
     *
     * @return \Pyz\Zed\DataImport\Business\Model\DataImporterConditional
     */
    public function createPyzDataImporterConditional(
        string $importType,
        DataReaderInterface $reader
    ): DataImporterConditional {
        return new DataImporterConditional($importType, $reader, $this->getGracefulRunnerFacade());
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface
     */
    public function createPyzCombinedProductOfferReferenceToProductOfferDataStep(): DataImportStepInterface
    {
        return new CombinedProductOfferReferenceToProductOfferDataStep();
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface
     */
    public function createPyzCombinedProductOfferToIdProductStep(): DataImportStepInterface
    {
        return new CombinedProductOfferToIdProductStep();
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface
     */
    public function createPyzCombinedPriceTypeToIdPriceTypeStep(): DataImportStepInterface
    {
        return new CombinedPriceTypeToIdPriceTypeStep();
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface
     */
    public function createPyzCombinedPriceProductWriterStep(): DataImportStepInterface
    {
        return new CombinedPriceProductWriterStep();
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface
     */
    public function createPyzCombinedStoreToIdStoreStep(): DataImportStepInterface
    {
        return new CombinedStoreToIdStoreStep();
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface
     */
    public function createPyzCombinedCurrencyToIdCurrencyStep(): DataImportStepInterface
    {
        return new CombinedCurrencyToIdCurrencyStep();
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface
     */
    public function createPyzCombinedPriceProductStoreWriterStep(): DataImportStepInterface
    {
        return new CombinedPriceProductStoreWriterStep();
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface
     */
    public function createPyzCombinedPreparePriceDataStep(): DataImportStepInterface
    {
        return new CombinedPreparePriceDataStep($this->getPriceProductFacade(), $this->getUtilEncodingService());
    }

    /**
     * @return \Pyz\Zed\DataImport\Business\Model\DataSet\DataSetConditionInterface
     */
    public function createPyzCombinedPriceProductOfferMandatoryColumnCondition(): DataSetConditionInterface
    {
        return new CombinedPriceProductOfferMandatoryColumnCondition();
    }
}
