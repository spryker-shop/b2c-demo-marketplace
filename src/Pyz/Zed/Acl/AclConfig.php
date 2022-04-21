<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Acl;

use ArrayObject;
use Generated\Shared\Transfer\AclEntityRuleTransfer;
use Generated\Shared\Transfer\RuleTransfer;
use Spryker\Shared\Acl\AclConstants;
use Spryker\Zed\Acl\AclConfig as SprykerAclConfig;

class AclConfig extends SprykerAclConfig
{
    protected const PYZ_RULE_TYPE_DENY = 'deny';

    /**
     * @return array
     */
    public function getInstallerRules(): array
    {
        $installerRules = parent::getInstallerRules();
        $installerRules = $this->addPyzMerchantPortalInstallerRules($installerRules);

        return $installerRules;
    }

    /**
     * @return array
     */
    public function getInstallerUsers(): array
    {
        return [
            'admin@spryker.com' => [
                'group' => AclConstants::ROOT_GROUP,
            ],
            'admin_de@spryker.com' => [
                'group' => AclConstants::ROOT_GROUP,
            ],
            'richard@spryker.com' => [
                'group' => AclConstants::ROOT_GROUP,
            ],
            'martha@video-king.nl' => [],
            'harald@spryker.com' => [],
            'jason.weidmann@budgetcamerasonline.com' => [],
            'michele@sony-experts.com' => [],
            //this is related to existent username and will be searched into the database
        ];
    }

    /**
     * @param string[][] $installerRules
     *
     * @return string[][]
     */
    protected function addPyzMerchantPortalInstallerRules(array $installerRules): array
    {
        $bundleNames = [
            'dashboard-merchant-portal-gui',
            'merchant-profile-merchant-portal-gui',
            'product-merchant-portal-gui',
            'product-offer-merchant-portal-gui',
            'security-merchant-portal-gui',
            'sales-merchant-portal-gui',
            'user-merchant-portal-gui',
            'dummy-merchant-portal-gui',
            'price-product-merchant-relationship-merchant-portal-gui',
        ];

        foreach ($bundleNames as $bundleName) {
            $installerRules[] = [
                'bundle' => $bundleName,
                'controller' => AclConstants::VALIDATOR_WILDCARD,
                'action' => AclConstants::VALIDATOR_WILDCARD,
                'type' => static::PYZ_RULE_TYPE_DENY,
                'role' => AclConstants::ROOT_ROLE,
            ];
        }

        return $installerRules;
    }

    /**
     * @return array
     */
    public function getInstallerRoles(): array
    {
        return $this->addPyzInstallerRootRole();
    }

    /**
     * @return mixed[]
     */
    protected function addPyzInstallerRootRole(): array
    {
        $entityRule = new AclEntityRuleTransfer();
        $entityRule->setEntity('*')
            ->setPermissionMask(0)
            ->setScope('global');

        $rule = (new RuleTransfer())
            ->setAction(AclConstants::VALIDATOR_WILDCARD)
            ->setBundle(AclConstants::VALIDATOR_WILDCARD)
            ->setController(AclConstants::VALIDATOR_WILDCARD)
            ->setType(AclConstants::ALLOW);

        return [
            [
                'name' => AclConstants::ROOT_ROLE,
                'group' => AclConstants::ROOT_GROUP,
                'aclEntityRules' => new ArrayObject([$entityRule]),
                'aclRules' => new ArrayObject([$rule]),
            ],
        ];
    }

    /**
     * @return array
     */
    public function getInstallerGroups(): array
    {
        return [
            [
                'name' => AclConstants::ROOT_GROUP,
                'reference' => AclConstants::ROOT_GROUP,
            ],
        ];
    }
}
