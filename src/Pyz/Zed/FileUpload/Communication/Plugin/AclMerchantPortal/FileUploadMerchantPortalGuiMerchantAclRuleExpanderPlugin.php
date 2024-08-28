<?php

declare(strict_types=1);

namespace Pyz\Zed\FileUpload\Communication\Plugin\AclMerchantPortal;

use Generated\Shared\Transfer\RuleTransfer;
use Spryker\Zed\AclMerchantPortalExtension\Dependency\Plugin\MerchantAclRuleExpanderPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

class FileUploadMerchantPortalGuiMerchantAclRuleExpanderPlugin extends AbstractPlugin implements MerchantAclRuleExpanderPluginInterface
{
    /**
     * @uses {@link \Spryker\Shared\Acl\AclConstants::VALIDATOR_WILDCARD}
     *
     * @var string
     */
    protected const RULE_VALIDATOR_WILDCARD = '*';

    /**
     * @uses {@link \Spryker\Shared\Acl\AclConstants::ALLOW}
     *
     * @var string
     */
    protected const RULE_TYPE_ALLOW = 'allow';

    /**
     * {@inheritDoc}
     * - Adds `product-merchant-portal-gui` to list of `AclRules`.
     *
     * @api
     *
     * @param list<\Generated\Shared\Transfer\RuleTransfer> $ruleTransfers
     *
     * @return list<\Generated\Shared\Transfer\RuleTransfer>
     */
    public function expand(array $ruleTransfers): array
    {
        $ruleTransfers[] = (new RuleTransfer())
            ->setBundle('file-upload-merchant-portal-gui')
            ->setController(static::RULE_VALIDATOR_WILDCARD)
            ->setAction(static::RULE_VALIDATOR_WILDCARD)
            ->setType(static::RULE_TYPE_ALLOW);

        return $ruleTransfers;
    }
}
