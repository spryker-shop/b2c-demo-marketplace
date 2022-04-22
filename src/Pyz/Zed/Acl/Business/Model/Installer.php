<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Acl\Business\Model;

use Pyz\Zed\Acl\Business\Acl\pyzAclConfigReaderInterface;
use Spryker\Zed\Acl\Business\Model\GroupInterface;
use Spryker\Zed\Acl\Business\Model\Installer as SprykerInstaller;
use Spryker\Zed\Acl\Business\Model\RoleInterface;
use Spryker\Zed\Acl\Business\Model\RuleInterface;
use Spryker\Zed\Acl\Business\Writer\RoleWriterInterface;
use Spryker\Zed\Acl\Dependency\Facade\AclToUserInterface;

class Installer extends SprykerInstaller implements InstallerInterface
{
    /**
     * @var \Spryker\Zed\Acl\Business\Model\GroupInterface
     */
    protected $group;

    /**
     * @var \Spryker\Zed\Acl\Business\Model\RoleInterface
     */
    protected $role;

    /**
     * @var \Spryker\Zed\Acl\Business\Model\RuleInterface
     */
    protected $rule;

    /**
     * @var \Spryker\Zed\Acl\Dependency\Facade\AclToUserInterface
     */
    protected $userFacade;

    /**
     * @var array<\Spryker\Zed\AclExtension\Dependency\Plugin\AclInstallerPluginInterface>
     */
    protected $aclInstallerPlugins;

    /**
     * @var \Spryker\Zed\Acl\Business\Acl\AclConfigReaderInterface
     */
    protected $aclConfigReader;

    /**
     * @var \Spryker\Zed\Acl\Business\Writer\RoleWriterInterface
     */
    protected $roleWriter;

    /**
     * @param \Spryker\Zed\Acl\Business\Model\GroupInterface $group
     * @param \Spryker\Zed\Acl\Business\Model\RoleInterface $role
     * @param \Spryker\Zed\Acl\Business\Model\RuleInterface $rule
     * @param \Spryker\Zed\Acl\Dependency\Facade\AclToUserInterface $userFacade
     * @param \Pyz\Zed\Acl\Business\Acl\pyzAclConfigReaderInterface $aclConfigReader
     * @param \Spryker\Zed\Acl\Business\Writer\RoleWriterInterface $roleWriter
     * @param array<\Spryker\Zed\AclExtension\Dependency\Plugin\AclInstallerPluginInterface> $aclInstallerPlugins
     */
    public function __construct(
        GroupInterface $group,
        RoleInterface $role,
        RuleInterface $rule,
        AclToUserInterface $userFacade,
        pyzAclConfigReaderInterface $aclConfigReader,
        RoleWriterInterface $roleWriter,
        array $aclInstallerPlugins
    ) {
        $this->group = $group;
        $this->role = $role;
        $this->rule = $rule;
        $this->userFacade = $userFacade;
        $this->aclConfigReader = $aclConfigReader;
        $this->roleWriter = $roleWriter;
        $this->aclInstallerPlugins = $aclInstallerPlugins;
    }
}
