<?php

namespace Pyz\Zed\Acl;

use Spryker\Zed\Acl\AclDependencyProvider as SprykerAclDependencyProvider;
use Spryker\Zed\MerchantUser\Communication\Plugin\Acl\MerchantUserAclInstallerPlugin;

class AclDependencyProvider extends SprykerAclDependencyProvider
{
    /**
     * @return \Spryker\Zed\AclExtension\Dependency\Plugin\AclInstallerPluginInterface[]
     */
    public function getAclInstallerPlugins(): array
    {
        return [
            new MerchantUserAclInstallerPlugin(),
        ];
    }
}
