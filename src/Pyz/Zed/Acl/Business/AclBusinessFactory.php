<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Acl\Business;

use Pyz\Zed\Acl\AclDependencyProvider;
use Pyz\Zed\Acl\Business\Acl\PyzAclConfigReader;
use Pyz\Zed\Acl\Business\Acl\PyzAclConfigReaderInterface;
use Pyz\Zed\Acl\Business\Model\PyzGroup;
use Pyz\Zed\Acl\Business\Model\PyzGroupInterface;
use Pyz\Zed\Acl\Business\Model\PyzInstaller;
use Pyz\Zed\Acl\Business\Model\PyzInstallerInterface;
use Pyz\Zed\Acl\Business\Model\PyzRole;
use Pyz\Zed\Acl\Business\Model\PyzRoleInterface;
use Pyz\Zed\Acl\Business\Model\PyzRoleWriter;
use Pyz\Zed\Acl\Business\Model\PyzRoleWriterInterface;
use Pyz\Zed\Acl\Business\Model\PyzRule;
use Pyz\Zed\Acl\Business\Model\PyzRuleInterface;
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
            $this->createPyzGroupModel(),
            $this->createPyzRoleModel(),
            $this->createPyzRuleModel(),
            $this->getProvidedDependency(AclDependencyProvider::PYZ_FACADE_USER),
            $this->createPyzAclConfigReader(),
            $this->createPyzRoleWriter(),
            $this->getAclInstallerPlugins(),
        );
    }

    /**
     * @return \Spryker\Zed\Acl\Business\Model\GroupInterface
     */
    public function createPyzGroupModel(): PyzGroupInterface
    {
        return new PyzGroup($this->getQueryContainer());
    }

    /**
     * @return \Pyz\Zed\Acl\Business\Model\PyzRoleInterface
     */
    public function createPyzRoleModel(): PyzRoleInterface
    {
        return new PyzRole(
            $this->createGroupModel(),
            $this->getQueryContainer(),
            $this->getAclRolesExpanderPlugins(),
            $this->getAclRolePostSavePlugins(),
        );
    }

    /**
     * @return \Pyz\Zed\Acl\Business\Model\PyzRuleInterface
     */
    public function createPyzRuleModel(): PyzRuleInterface
    {
        return new PyzRule(
            $this->createGroupModel(),
            $this->getQueryContainer(),
            $this->getProvidedDependency(AclDependencyProvider::PYZ_FACADE_USER),
            $this->createRuleValidatorHelper(),
            $this->getConfig(),
        );
    }

    /**
     * @return \Pyz\Zed\Acl\Business\Model\PyzRoleWriterInterface
     */
    public function createPyzRoleWriter(): PyzRoleWriterInterface
    {
        return new PyzRoleWriter(
            $this->getEntityManager(),
            $this->getRepository(),
            $this->getAclRolePostSavePlugins(),
        );
    }
}
