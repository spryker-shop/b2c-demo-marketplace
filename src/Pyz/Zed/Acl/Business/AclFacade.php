<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Acl\Business;

use Spryker\Zed\Acl\Business\AclFacade as SprykerAclFacade;

/**
 * @method \Pyz\Zed\Acl\Business\AclBusinessFactory getFactory()
 */
class AclFacade extends SprykerAclFacade
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return void
     */
    public function install()
    {
        $this->getFactory()->createPyzInstallerModel()->install();
    }
}
