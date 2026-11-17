<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\Captcha;

use Spryker\Zed\AgentSecurityBlockerMerchantPortalGui\Communication\Plugin\Captcha\SecurityBlockerAgentMerchantPortalCaptchaRequirementPlugin;
use Spryker\Zed\Captcha\CaptchaDependencyProvider as SprykerCaptchaDependencyProvider;
use Spryker\Zed\SecurityBlockerBackofficeGui\Communication\Plugin\Captcha\SecurityBlockerBackofficeUserCaptchaRequirementPlugin;
use Spryker\Zed\SecurityBlockerMerchantPortalGui\Communication\Plugin\Captcha\SecurityBlockerMerchantPortalUserCaptchaRequirementPlugin;

class CaptchaDependencyProvider extends SprykerCaptchaDependencyProvider
{
    /**
     * @return list<\Spryker\Shared\CaptchaExtension\Dependency\Plugin\CaptchaRequirementPluginInterface>
     */
    protected function getCaptchaRequirementPlugins(): array
    {
        return [
            new SecurityBlockerBackofficeUserCaptchaRequirementPlugin(),
            new SecurityBlockerMerchantPortalUserCaptchaRequirementPlugin(),
            new SecurityBlockerAgentMerchantPortalCaptchaRequirementPlugin(),
        ];
    }
}
