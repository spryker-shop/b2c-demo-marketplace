<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\MerchantProductImport\Business;

use Pyz\Zed\MerchantProductImport\Business\Reader\ImportUploadReader;
use Pyz\Zed\MerchantProductImport\Business\Reader\ImportUploadReaderInterface;
use Pyz\Zed\MerchantProductImport\Business\Writer\ImportUploadWriter;
use Pyz\Zed\MerchantProductImport\Business\Writer\ImportUploadWriterInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \Pyz\Zed\MerchantProductImport\MerchantProductImportConfig getConfig()
 * @method \Pyz\Zed\MerchantProductImport\Persistence\MerchantProductImportRepositoryInterface getRepository()
 * @method \Pyz\Zed\MerchantProductImport\Persistence\MerchantProductImportEntityManagerInterface getEntityManager()
 */
class MerchantProductImportBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \Pyz\Zed\MerchantProductImport\Business\Reader\ImportUploadReaderInterface
     */
    public function createImportUploadReader(): ImportUploadReaderInterface
    {
        return new ImportUploadReader(
            $this->getConfig(),
            $this->getRepository(),
        );
    }

    /**
     * @return \Pyz\Zed\MerchantProductImport\Business\Writer\ImportUploadWriterInterface
     */
    public function createImportUploadWriter(): ImportUploadWriterInterface
    {
        return new ImportUploadWriter(
            $this->getConfig(),
            $this->getEntityManager(),
        );
    }
}
