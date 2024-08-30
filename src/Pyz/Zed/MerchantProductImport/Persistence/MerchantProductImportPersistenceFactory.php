<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\MerchantProductImport\Persistence;

use Orm\Zed\MerchantProductImport\Persistence\PyzImportUploadQuery;
use Pyz\Zed\MerchantProductImport\Persistence\Propel\Mapper\ImportUploadMapper;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \Pyz\Zed\MerchantProductImport\MerchantProductImportConfig getConfig()
 * @method \Pyz\Zed\MerchantProductImport\Persistence\MerchantProductImportRepositoryInterface getRepository()
 * @method \Pyz\Zed\MerchantProductImport\Persistence\MerchantProductImportEntityManagerInterface getEntityManager()
 */
class MerchantProductImportPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\MerchantProductImport\Persistence\PyzImportUploadQuery
     */
    public function createImportUploadPropelQuery(): PyzImportUploadQuery
    {
        return PyzImportUploadQuery::create();
    }

    /**
     * @return \Pyz\Zed\MerchantProductImport\Persistence\Propel\Mapper\ImportUploadMapper
     */
    public function createImportUploadMapper(): ImportUploadMapper
    {
        return new ImportUploadMapper();
    }
}
