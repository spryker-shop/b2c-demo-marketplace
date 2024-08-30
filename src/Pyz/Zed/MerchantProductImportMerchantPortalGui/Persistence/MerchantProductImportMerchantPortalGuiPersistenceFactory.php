<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\MerchantProductImportMerchantPortalGui\Persistence;

use Orm\Zed\MerchantProductImport\Persistence\PyzImportUploadQuery;
use Pyz\Zed\MerchantProductImportMerchantPortalGui\MerchantProductImportMerchantPortalGuiDependencyProvider;
use Pyz\Zed\MerchantProductImportMerchantPortalGui\Persistence\Mapper\ImportUploadTableDataMapper;
use Pyz\Zed\MerchantProductImportMerchantPortalGui\Persistence\Mapper\ImportUploadTableDataMapperInterface;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \Pyz\Zed\MerchantProductImportMerchantPortalGui\MerchantProductImportMerchantPortalGuiConfig getConfig()
 * @method \Pyz\Zed\MerchantProductImportMerchantPortalGui\Persistence\MerchantProductImportMerchantPortalGuiRepositoryInterface getRepository()
 */
class MerchantProductImportMerchantPortalGuiPersistenceFactory extends AbstractPersistenceFactory
{
    public function createImportUploadTableDataMapper(): ImportUploadTableDataMapperInterface
    {
        return new ImportUploadTableDataMapper($this->getConfig());
    }

    public function getImportUploadQuery(): PyzImportUploadQuery
    {
        return $this->getProvidedDependency(MerchantProductImportMerchantPortalGuiDependencyProvider::QUERY_IMPORT_UPLOAD);
    }
}
