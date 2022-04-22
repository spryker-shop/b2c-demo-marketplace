<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Acl\Business\Model;

use Generated\Shared\Transfer\RoleTransfer;
use Generated\Shared\Transfer\RuleTransfer;
use Pyz\Zed\Acl\Business\Acl\PyzAclConfigReaderInterface;
use Spryker\Zed\Acl\Business\Exception\GroupNotFoundException;
use Spryker\Zed\User\Business\Exception\UserNotFoundException;

class PyzInstaller implements PyzInstallerInterface
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
     * @var \Pyz\Zed\Acl\Business\Acl\PyzAclConfigReaderInterface
     */
    protected $aclConfigReader;

    /**
     * @var \Spryker\Zed\Acl\Business\Writer\RoleWriterInterface
     */
    protected $roleWriter;

    /**
     * @param \Pyz\Zed\Acl\Business\Model\PyzGroupInterface $group
     * @param \Pyz\Zed\Acl\Business\Model\PyzRoleInterface $role
     * @param \Pyz\Zed\Acl\Business\Model\PyzRuleInterface $rule
     * @param \Pyz\Zed\Acl\Business\Model\PyzAclToUserInterface $userFacade
     * @param \Pyz\Zed\Acl\Business\Acl\PyzAclConfigReaderInterface $aclConfigReader
     * @param \Pyz\Zed\Acl\Business\Model\PyzRoleWriterInterface $roleWriter
     * @param array<\Spryker\Zed\AclExtension\Dependency\Plugin\AclInstallerPluginInterface> $aclInstallerPlugins
     */
    public function __construct(
        PyzGroupInterface $group,
        PyzRoleInterface $role,
        PyzRuleInterface $rule,
        PyzAclToUserInterface $userFacade,
        PyzAclConfigReaderInterface $aclConfigReader,
        PyzRoleWriterInterface $roleWriter,
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

    /**
     * Main Installation Method
     *
     * @return void
     */
    public function install(): void
    {
        $this->installGroups();
        $this->installRoles();
        $this->installUserGroupRelations();
    }

    /**
     * @return void
     */
    protected function installGroups(): void
    {
        foreach ($this->getGroups() as $groupTransfer) {
            $groupTransfer->requireName();
            if ($this->group->hasGroupName($groupTransfer->getName())) {
                continue;
            }
            $this->group->save($groupTransfer);
        }
    }

    /**
     * @return void
     */
    protected function installRoles(): void
    {
        foreach ($this->getRoles() as $roleTransfer) {
            $roleTransfer->requireName()
                ->requireAclGroup()
                ->getAclGroup()
                ->requireName();

            $existingRoleTransfer = $this->role->findRoleByName($roleTransfer->getName());
            if (!$existingRoleTransfer) {
                $existingRoleTransfer = $this->createRole($roleTransfer);
            }

            foreach ($roleTransfer->getAclRules() as $ruleTransfer) {
                $this->addRuleToRole($ruleTransfer, $existingRoleTransfer);
            }
        }
    }

    /**
     * @param \Generated\Shared\Transfer\RoleTransfer $roleTransfer
     *
     * @throws \Spryker\Zed\Acl\Business\Exception\GroupNotFoundException
     *
     * @return \Generated\Shared\Transfer\RoleTransfer
     */
    protected function createRole(RoleTransfer $roleTransfer): RoleTransfer
    {
        $groupTransfer = $this->group->getByName($roleTransfer->getAclGroup()->getName());
        if (!$groupTransfer->getIdAclGroup()) {
            throw new GroupNotFoundException(sprintf('The group with name %s was not found', $roleTransfer->getAclGroup()->getName()));
        }
        $roleTransfer = $this->roleWriter->createRole($roleTransfer);
        $this->group->addRoleToGroup($roleTransfer->getIdAclRole(), $groupTransfer->getIdAclGroup());

        return $roleTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\RuleTransfer $ruleTransfer
     * @param \Generated\Shared\Transfer\RoleTransfer $roleTransfer
     *
     * @return \Generated\Shared\Transfer\RuleTransfer
     */
    protected function addRuleToRole(RuleTransfer $ruleTransfer, RoleTransfer $roleTransfer): RuleTransfer
    {
        $ruleTransfer->requireAction()
            ->requireBundle()
            ->requireController()
            ->requireType();

        $existsRoleRule = $this->rule->existsRoleRule(
            $roleTransfer->getIdAclRole(),
            $ruleTransfer->getBundle(),
            $ruleTransfer->getController(),
            $ruleTransfer->getAction(),
            $ruleTransfer->getType(),
        );
        if ($existsRoleRule) {
            return $ruleTransfer;
        }
        $ruleTransfer->setFkAclRole($roleTransfer->getIdAclRole());

        return $this->rule->addRule($ruleTransfer);
    }

    /**
     * @throws \Spryker\Zed\Acl\Business\Exception\GroupNotFoundException
     * @throws \Spryker\Zed\User\Business\Exception\UserNotFoundException
     *
     * @return void
     */
    protected function installUserGroupRelations(): void
    {
        foreach ($this->aclConfigReader->getUserGroupRelations() as $userTransfer) {
            foreach ($userTransfer->getAclGroups() as $groupTransfer) {
                $existingGroupTransfer = $this->group->getByName($groupTransfer->getName());
                if (!$existingGroupTransfer->getIdAclGroup()) {
                    throw new GroupNotFoundException(sprintf('The group with name %s was not found', $groupTransfer->getName()));
                }
                $existingUserTransfer = $this->userFacade->getUserByUsername($userTransfer->getUsername());
                if (!$existingUserTransfer->getIdUser()) {
                    throw new UserNotFoundException(sprintf('The user with username %s was not found', $userTransfer->getUsername()));
                }

                if ($this->group->hasUser($existingGroupTransfer->getIdAclGroup(), $existingUserTransfer->getIdUser())) {
                    continue;
                }
                $this->group->addUser($existingGroupTransfer->getIdAclGroup(), $existingUserTransfer->getIdUser());
            }
        }
    }

    /**
     * @return array<\Generated\Shared\Transfer\RoleTransfer>
     */
    protected function getRoles(): array
    {
        $roleTransfers = $this->aclConfigReader->getRoles();

        foreach ($this->aclInstallerPlugins as $aclInstallerPlugin) {
            foreach ($aclInstallerPlugin->getRoles() as $roleTransfer) {
                $roleTransfers[] = $roleTransfer;
            }
        }

        return $roleTransfers;
    }

    /**
     * @return array<\Generated\Shared\Transfer\GroupTransfer>
     */
    protected function getGroups(): array
    {
        $groupTransfers = $this->aclConfigReader->getGroups();

        foreach ($this->aclInstallerPlugins as $aclInstallerPlugin) {
            foreach ($aclInstallerPlugin->getGroups() as $groupTransfer) {
                $groupTransfers[] = $groupTransfer;
            }
        }

        return $groupTransfers;
    }
}
