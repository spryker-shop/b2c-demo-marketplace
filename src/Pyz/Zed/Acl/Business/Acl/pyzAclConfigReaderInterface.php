<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Acl\Business\Acl;

interface pyzAclConfigReaderInterface
{
    /**
     * @return array<\Generated\Shared\Transfer\GroupTransfer>
     */
    public function getGroups(): array;

    /**
     * @return array<\Generated\Shared\Transfer\RoleTransfer>
     */
    public function getRoles(): array;

    /**
     * @return array<\Generated\Shared\Transfer\UserTransfer>
     */
    public function getUserGroupRelations(): array;
}
