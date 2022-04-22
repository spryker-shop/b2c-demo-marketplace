<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Acl\Business;

use Pyz\Zed\Acl\AclDependencyProvider;
use Pyz\Zed\Acl\Business\Acl\pyzAclConfigReader;
use Pyz\Zed\Acl\Business\Acl\pyzAclConfigReaderInterface;
use Spryker\Zed\Acl\Business\AclBusinessFactory as SprykerAclBusinessFactory;
use Spryker\Zed\Acl\Business\Model\Installer;
use Spryker\Zed\Acl\Business\Model\InstallerInterface;

class AclBusinessFactory extends SprykerAclBusinessFactory
{
    // TODO: Should be removed after MP-6740 integration.

    /**
     * @var string
     */
    public const PYZ_FACADE_USER = 'user facade';

    /**
     * @return \Pyz\Zed\Acl\Business\Acl\pyzAclConfigReader
     */
    public function createPyzAclConfigReader(): pyzAclConfigReaderInterface
    {
        return new pyzAclConfigReader($this->getConfig());
    }

    public function createPyzInstallerModel(): InstallerInterface
    {
        return new Installer(
            $this->createGroupModel(),
            $this->createRoleModel(),
            $this->createRuleModel(),
            $this->getProvidedDependency(AclDependencyProvider::PYZ_FACADE_USER),
            $this->createPyzAclConfigReader(),
            $this->createRoleWriter(),
            $this->getAclInstallerPlugins(),
        );
    }
}
