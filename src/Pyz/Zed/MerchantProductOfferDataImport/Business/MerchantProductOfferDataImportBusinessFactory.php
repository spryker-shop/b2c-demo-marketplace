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
    public function pyzGetCombinedMerchantProductOfferDataImporter(): DataImporterInterface
    {
        $dataImporter = $this->pyzGetConditionalCsvDataImporterFromConfig(
            $this->getConfig()->pyzGetCombinedMerchantProductOfferDataImporterConfiguration()
        );

        $dataSetStepBroker = $this->createTransactionAwareDataSetStepBroker();
        $dataSetStepBroker
            ->addStep($this->pyzCreateCombinedMerchantReferenceToIdMerchantStep())
            ->addStep($this->pyzCreateCombinedConcreteSkuValidationStep())
            ->addStep($this->pyzCreateCombinedMerchantSkuValidationStep())
            ->addStep($this->pyzCreateCombinedApprovalStatusValidationStep())
            ->addStep($this->pyzCreateCombinedMerchantProductOfferWriterStep());

        $dataImporter
            ->setDataSetCondition($this->pyzCreateCombinedMerchantProductOfferMandatoryColumnCondition())
            ->addDataSetStepBroker($dataSetStepBroker);

        return $dataImporter;
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataImporterInterface
     */
    public function pyzGetCombinedMerchantProductOfferStoreDataImporter(): DataImporterInterface
    {
        $dataImporter = $this->pyzGetConditionalCsvDataImporterFromConfig(
            $this->getConfig()->pyzGetCombinedMerchantProductOfferStoreDataImporterConfiguration()
        );

        $dataSetStepBroker = $this->createTransactionAwareDataSetStepBroker();
        $dataSetStepBroker
            ->addStep($this->createProductOfferReferenceToIdProductOfferStep())
            ->addStep($this->pyzCreateCombinedStoreNameToIdStoreStep())
            ->addStep($this->createMerchantProductOfferStoreWriterStep());

        $dataImporter
            ->setDataSetCondition($this->pyzCreateCombinedMerchantProductOfferStoreMandatoryColumnCondition())
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
    public function pyzCreateCombinedMerchantReferenceToIdMerchantStep(): DataImportStepInterface
    {
        return new CombinedMerchantReferenceToIdMerchantStep();
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface
     */
    public function pyzCreateCombinedConcreteSkuValidationStep(): DataImportStepInterface
    {
        return new CombinedConcreteSkuValidationStep();
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface
     */
    public function pyzCreateCombinedMerchantSkuValidationStep(): DataImportStepInterface
    {
        return new CombinedMerchantSkuValidationStep();
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface
     */
    public function pyzCreateCombinedMerchantProductOfferWriterStep(): DataImportStepInterface
    {
        return new CombinedMerchantProductOfferWriterStep($this->getEventFacade());
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface
     */
    public function pyzCreateCombinedStoreNameToIdStoreStep(): DataImportStepInterface
    {
        return new CombinedStoreNameToIdStoreStep();
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface
     */
    public function pyzCreateCombinedApprovalStatusValidationStep(): DataImportStepInterface
    {
        return new CombinedApprovalStatusValidationStep();
    }

    /**
     * @return \Pyz\Zed\DataImport\Business\Model\DataSet\DataSetConditionInterface
     */
    public function pyzCreateCombinedMerchantProductOfferStoreMandatoryColumnCondition(): DataSetConditionInterface
    {
        return new CombinedMerchantProductOfferStoreMandatoryColumnCondition();
    }

    /**
     * @return \Pyz\Zed\DataImport\Business\Model\DataSet\DataSetConditionInterface
     */
    public function pyzCreateCombinedMerchantProductOfferMandatoryColumnCondition(): DataSetConditionInterface
    {
        return new CombinedMerchantProductOfferMandatoryColumnCondition();
    }
}
