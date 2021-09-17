<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\CartPage;

use SprykerShop\Yves\CartPage\CartPageConfig as SprykerShopCartPageConfig;

class CartPageConfig extends SprykerShopCartPageConfig
{
    public const IS_CART_CART_ITEMS_VIA_AJAX_LOAD_ENABLED = true;
    public const IS_LOADING_UPSELLING_PRODUCTS_VIA_AJAX_ENABLED = true;
}
