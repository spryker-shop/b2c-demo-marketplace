<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Acl\Business;

use Pyz\Zed\Acl\Business\Acl\AclConfigReader;
use Spryker\Zed\Acl\Business\Acl\AclConfigReaderInterface;
use Spryker\Zed\Acl\Business\AclBusinessFactory as SprykerAclBusinessFactory;

class AclBusinessFactory extends SprykerAclBusinessFactory
{
    // TODO: Should be removed after MP-6691 integration.
    /**
     * @return \Spryker\Zed\Acl\Business\Acl\AclConfigReaderInterface
     */
    public function createAclConfigReader(): AclConfigReaderInterface
    {
        return new AclConfigReader($this->getConfig());
    }
}
