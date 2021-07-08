<?php

namespace Pyz\Zed\SalesReturn;

use Spryker\Zed\SalesReturn\SalesReturnConfig as SprykerSalesReturnConfig;

class SalesReturnConfig extends SprykerSalesReturnConfig
{
    protected const RETURNABLE_STATE_NAMES = [
        'shipped',
        'delivered',
        'shipped by merchant',
    ];
}
