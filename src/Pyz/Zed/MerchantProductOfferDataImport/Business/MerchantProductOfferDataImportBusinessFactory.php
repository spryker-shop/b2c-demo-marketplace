<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\MerchantProductOfferDataImport\Business;

use Generated\Shared\Transfer\DataImporterConfigurationTransfer;
use Pyz\Zed\DataImport\Business\Model\DataImporterConditional;
use Pyz\Zed\DataImport\Business\Model\DataSet\DataSetConditionInterface;
use Pyz\Zed\MerchantProductOfferDataImport\Business\Model\Condition\CombinedMerchantProductOfferMandatoryColumnCondition;
use Pyz\Zed\MerchantProductOfferDataImport\Business\Model\Condition\CombinedMerchantProductOfferStoreMandatoryColumnCondition;
use Pyz\Zed\MerchantProductOfferDataImport\Business\Model\Step\CombinedApprovalStatusValidationStep;
use Pyz\Zed\MerchantProductOfferDataImport\Business\Model\Step\CombinedConcreteSkuValidationStep;
use Pyz\Zed\MerchantProductOfferDataImport\Business\Model\Step\CombinedMerchantProductOfferWriterStep;
use Pyz\Zed\MerchantProductOfferDataImport\Business\Model\Step\CombinedMerchantReferenceToIdMerchantStep;
use Pyz\Zed\MerchantProductOfferDataImport\Business\Model\Step\CombinedMerchantSkuValidationStep;
use Pyz\Zed\MerchantProductOfferDataImport\Business\Model\Step\CombinedStoreNameToIdStoreStep;
use Spryker\Zed\DataImport\Business\Model\DataImporterInterface;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface;
use Spryker\Zed\DataImport\Business\Model\DataReader\DataReaderInterface;
use Spryker\Zed\MerchantProductOfferDataImport\Business\MerchantProductOfferDataImportBusinessFactory as SprykerMerchantProductOfferDataImportBusinessFactory;

/**
 * @method \Pyz\Zed\MerchantProductOfferDataImport\MerchantProductOfferDataImportConfig getConfig()
 */
class MerchantProductOfferDataImportBusinessFactory extends SprykerMerchantProductOfferDataImportBusinessFactory
{
    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataImporterInterface
     */
    public function getPyzCombinedMerchantProductOfferDataImporter(): DataImporterInterface
    {
        $dataImporter = $this->getPyzConditionalCsvDataImporterFromConfig(
            $this->getConfig()->getPyzCombinedMerchantProductOfferDataImporterConfiguration(),
        );

        $dataSetStepBroker = $this->createTransactionAwareDataSetStepBroker();
        $dataSetStepBroker
            ->addStep($this->createPyzCombinedMerchantReferenceToIdMerchantStep())
            ->addStep($this->createPyzCombinedConcreteSkuValidationStep())
            ->addStep($this->createPyzCombinedMerchantSkuValidationStep())
            ->addStep($this->createPyzCombinedApprovalStatusValidationStep())
            ->addStep($this->createPyzCombinedMerchantProductOfferWriterStep());

        $dataImporter
            ->setDataSetCondition($this->createPyzCombinedMerchantProductOfferMandatoryColumnCondition())
            ->addDataSetStepBroker($dataSetStepBroker);

        return $dataImporter;
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataImporterInterface
     */
    public function getPyzCombinedMerchantProductOfferStoreDataImporter(): DataImporterInterface
    {
        $dataImporter = $this->getPyzConditionalCsvDataImporterFromConfig(
            $this->getConfig()->getPyzCombinedMerchantProductOfferStoreDataImporterConfiguration(),
        );

        $dataSetStepBroker = $this->createTransactionAwareDataSetStepBroker();
        $dataSetStepBroker
            ->addStep($this->createProductOfferReferenceToIdProductOfferStep())
            ->addStep($this->createPyzCombinedStoreNameToIdStoreStep())
            ->addStep($this->createMerchantProductOfferStoreWriterStep());

        $dataImporter
            ->setDataSetCondition($this->createPyzCombinedMerchantProductOfferStoreMandatoryColumnCondition())
            ->addDataSetStepBroker($dataSetStepBroker);

        return $dataImporter;
    }

    /**
     * @param \Generated\Shared\Transfer\DataImporterConfigurationTransfer $dataImporterConfigurationTransfer
     *
     * @return \Pyz\Zed\DataImport\Business\Model\DataImporterConditional
     */
    public function getPyzConditionalCsvDataImporterFromConfig(
        DataImporterConfigurationTransfer $dataImporterConfigurationTransfer,
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
        DataReaderInterface $reader,
    ): DataImporterConditional {
        return new DataImporterConditional($importType, $reader, $this->getGracefulRunnerFacade());
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface
     */
    public function createPyzCombinedMerchantReferenceToIdMerchantStep(): DataImportStepInterface
    {
        return new CombinedMerchantReferenceToIdMerchantStep();
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface
     */
    public function createPyzCombinedConcreteSkuValidationStep(): DataImportStepInterface
    {
        return new CombinedConcreteSkuValidationStep();
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface
     */
    public function createPyzCombinedMerchantSkuValidationStep(): DataImportStepInterface
    {
        return new CombinedMerchantSkuValidationStep();
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface
     */
    public function createPyzCombinedMerchantProductOfferWriterStep(): DataImportStepInterface
    {
        return new CombinedMerchantProductOfferWriterStep($this->getEventFacade());
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface
     */
    public function createPyzCombinedStoreNameToIdStoreStep(): DataImportStepInterface
    {
        return new CombinedStoreNameToIdStoreStep();
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface
     */
    public function createPyzCombinedApprovalStatusValidationStep(): DataImportStepInterface
    {
        return new CombinedApprovalStatusValidationStep();
    }

    /**
     * @return \Pyz\Zed\DataImport\Business\Model\DataSet\DataSetConditionInterface
     */
    public function createPyzCombinedMerchantProductOfferStoreMandatoryColumnCondition(): DataSetConditionInterface
    {
        return new CombinedMerchantProductOfferStoreMandatoryColumnCondition();
    }

    /**
     * @return \Pyz\Zed\DataImport\Business\Model\DataSet\DataSetConditionInterface
     */
    public function createPyzCombinedMerchantProductOfferMandatoryColumnCondition(): DataSetConditionInterface
    {
        return new CombinedMerchantProductOfferMandatoryColumnCondition();
    }
}
