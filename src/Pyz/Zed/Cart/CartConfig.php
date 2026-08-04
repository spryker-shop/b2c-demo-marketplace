<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\Cart;

use Spryker\Zed\Cart\CartConfig as SprykerCartConfig;

class CartConfig extends SprykerCartConfig
{
    public function isCartReloadOnPreCheckFailureEnabled(): bool
    {
        return true;
    }
}
