<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\AclMerchantPortal\Business\Expander\AclEntity;

use Generated\Shared\Transfer\AclEntityMetadataConfigTransfer;
use Orm\Zed\EventBehavior\Persistence\SpyEventBehaviorEntityChange;
use Spryker\Zed\AclMerchantPortal\Business\Expander\AclEntity\AclEntityMetadataConfigExpander as SprykerAclEntityMetadataConfigExpander;

class AclEntityMetadataConfigExpander extends SprykerAclEntityMetadataConfigExpander
{
    /**
     * @param \Generated\Shared\Transfer\AclEntityMetadataConfigTransfer $aclEntityMetadataConfigTransfer
     *
     * @return \Generated\Shared\Transfer\AclEntityMetadataConfigTransfer
     */
    public function expandAclEntityMetadataConfigWithAllowList(
        AclEntityMetadataConfigTransfer $aclEntityMetadataConfigTransfer
    ): AclEntityMetadataConfigTransfer {
        $aclEntityMetadataConfigTransfer = parent::expandAclEntityMetadataConfigWithAllowList($aclEntityMetadataConfigTransfer);

        $aclEntityMetadataConfigTransfer->addAclEntityAllowListItem(SpyEventBehaviorEntityChange::class);

        return $aclEntityMetadataConfigTransfer;
    }
}
