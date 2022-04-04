<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Acl\Business\Acl;

use Generated\Shared\Transfer\GroupTransfer;
use Spryker\Zed\Acl\Business\Acl\AclConfigReader as SprykerAclConfigReader;

class AclConfigReader extends SprykerAclConfigReader
{
    // TODO: Should be removed after MP-6691 integration.
    /**
     * @return array<\Generated\Shared\Transfer\GroupTransfer>
     */
    public function getGroups(): array
    {
        $groupTransfers = [];
        foreach ($this->aclConfig->getInstallerGroups() as $groupData) {
            $groupTransfers[] = (new GroupTransfer())
                ->fromArray($groupData, true);
        }

        return $groupTransfers;
    }
}
