<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\RuleEngine;

use Spryker\Zed\MerchantCommission\Communication\Plugin\RuleEngine\MerchantCommissionItemCollectorRuleSpecificationProviderPlugin;
use Spryker\Zed\MerchantCommission\Communication\Plugin\RuleEngine\MerchantCommissionOrderDecisionRuleSpecificationProviderPlugin;
use Spryker\Zed\RuleEngine\RuleEngineDependencyProvider as SprykerRuleEngineDependencyProvider;

class RuleEngineDependencyProvider extends SprykerRuleEngineDependencyProvider
{
    /**
     * @return list<\Spryker\Zed\RuleEngineExtension\Communication\Dependency\Plugin\RuleSpecificationProviderPluginInterface>
     */
    protected function getRuleSpecificationProviderPlugins(): array
    {
        return [
            new MerchantCommissionItemCollectorRuleSpecificationProviderPlugin(),
            new MerchantCommissionOrderDecisionRuleSpecificationProviderPlugin(),
        ];
    }
}
