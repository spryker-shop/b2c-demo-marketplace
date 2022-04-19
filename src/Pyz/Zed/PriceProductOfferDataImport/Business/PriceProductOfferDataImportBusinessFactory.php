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
    public function pyzGetCombinedPriceProductOfferDataImport(): DataImporterInterface
    {
        $dataImporter = $this->pyzGetConditionalCsvDataImporterFromConfig(
            $this->getConfig()->pyzGetCombinedPriceProductOfferDataImporterConfiguration()
        );

        $dataSetStepBroker = $this->createTransactionAwareDataSetStepBroker();
        $dataSetStepBroker
            ->addStep($this->pyzCreateCombinedProductOfferReferenceToProductOfferDataStep())
            ->addStep($this->pyzCreateCombinedProductOfferToIdProductStep())
            ->addStep($this->pyzCreateCombinedPriceTypeToIdPriceTypeStep())
            ->addStep($this->pyzCreateCombinedPriceProductWriterStep())
            ->addStep($this->pyzCreateCombinedStoreToIdStoreStep())
            ->addStep($this->pyzCreateCombinedCurrencyToIdCurrencyStep())
            ->addStep($this->pyzCreateCombinedPreparePriceDataStep())
            ->addStep($this->pyzCreateCombinedPriceProductStoreWriterStep())
            ->addStep($this->createPriceProductOfferWriterStep());

        $dataImporter
            ->setDataSetCondition($this->pyzCreateCombinedPriceProductOfferMandatoryColumnCondition())
            ->addDataSetStepBroker($dataSetStepBroker);

        return $dataImporter;
    }

    /**
     * @param \Generated\Shared\Transfer\DataImporterConfigurationTransfer $dataImporterConfigurationTransfer
     *
     * @return \Pyz\Zed\DataImport\Business\Model\DataImporterConditional
     */
    public function pyzGetConditionalCsvDataImporterFromConfig(
        DataImporterConfigurationTransfer $dataImporterConfigurationTransfer
    ): DataImporterConditional {
        $csvReader = $this->createCsvReaderFromConfig($dataImporterConfigurationTransfer->getReaderConfiguration());

        return $this->pyzCreateDataImporterConditional($dataImporterConfigurationTransfer->getImportType(), $csvReader);
    }

    /**
     * @param string $importType
     * @param \Spryker\Zed\DataImport\Business\Model\DataReader\DataReaderInterface $reader
     *
     * @return \Pyz\Zed\DataImport\Business\Model\DataImporterConditional
     */
    public function pyzCreateDataImporterConditional(
        string $importType,
        DataReaderInterface $reader
    ): DataImporterConditional {
        return new DataImporterConditional($importType, $reader, $this->getGracefulRunnerFacade());
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface
     */
    public function pyzCreateCombinedProductOfferReferenceToProductOfferDataStep(): DataImportStepInterface
    {
        return new CombinedProductOfferReferenceToProductOfferDataStep();
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface
     */
    public function pyzCreateCombinedProductOfferToIdProductStep(): DataImportStepInterface
    {
        return new CombinedProductOfferToIdProductStep();
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface
     */
    public function pyzCreateCombinedPriceTypeToIdPriceTypeStep(): DataImportStepInterface
    {
        return new CombinedPriceTypeToIdPriceTypeStep();
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface
     */
    public function pyzCreateCombinedPriceProductWriterStep(): DataImportStepInterface
    {
        return new CombinedPriceProductWriterStep();
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface
     */
    public function pyzCreateCombinedStoreToIdStoreStep(): DataImportStepInterface
    {
        return new CombinedStoreToIdStoreStep();
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface
     */
    public function pyzCreateCombinedCurrencyToIdCurrencyStep(): DataImportStepInterface
    {
        return new CombinedCurrencyToIdCurrencyStep();
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface
     */
    public function pyzCreateCombinedPriceProductStoreWriterStep(): DataImportStepInterface
    {
        return new CombinedPriceProductStoreWriterStep();
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface
     */
    public function pyzCreateCombinedPreparePriceDataStep(): DataImportStepInterface
    {
        return new CombinedPreparePriceDataStep($this->getPriceProductFacade(), $this->getUtilEncodingService());
    }

    /**
     * @return \Pyz\Zed\DataImport\Business\Model\DataSet\DataSetConditionInterface
     */
    public function pyzCreateCombinedPriceProductOfferMandatoryColumnCondition(): DataSetConditionInterface
    {
        return new CombinedPriceProductOfferMandatoryColumnCondition();
    }
}
