<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Acl\Business;

use Pyz\Zed\Acl\AclDependencyProvider;
use Pyz\Zed\Acl\Business\Acl\PyzAclConfigReader;
use Pyz\Zed\Acl\Business\Acl\PyzAclConfigReaderInterface;
use Pyz\Zed\Acl\Business\Model\PyzInstaller;
use Pyz\Zed\Acl\Business\Model\PyzInstallerInterface;
use Spryker\Zed\Acl\Business\AclBusinessFactory as SprykerAclBusinessFactory;

class AclBusinessFactory extends SprykerAclBusinessFactory
{
    // TODO: Should be removed after MP-6740 integration.

    /**
     * @var string
     */
    public const PYZ_FACADE_USER = 'user facade';

    /**
     * @return \Pyz\Zed\Acl\Business\Acl\PyzAclConfigReader
     */
    public function createPyzAclConfigReader(): PyzAclConfigReaderInterface
    {
        return new PyzAclConfigReader($this->getConfig());
    }

    /**
     * @return \Pyz\Zed\Acl\Business\Model\PyzInstallerInterface
     */
    public function createPyzInstallerModel(): PyzInstallerInterface
    {
        return new PyzInstaller(
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
