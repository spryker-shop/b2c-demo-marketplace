<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\AclMerchantPortal\Business;

use Pyz\Zed\AclMerchantPortal\Business\Expander\AclEntity\AclEntityMetadataConfigExpander;
use Spryker\Zed\AclMerchantPortal\Business\AclMerchantPortalBusinessFactory as SprykerAclMerchantPortalBusinessFactory;
use Spryker\Zed\AclMerchantPortal\Business\Expander\AclEntity\AclEntityMetadataConfigExpanderInterface;

class AclMerchantPortalBusinessFactory extends SprykerAclMerchantPortalBusinessFactory
{
    public function createAclEntityMetadataConfigExpander(): AclEntityMetadataConfigExpanderInterface
    {
        return new AclEntityMetadataConfigExpander();
    }
}
