<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Shared\ContentNavigation;

use Spryker\Shared\ContentNavigation\ContentNavigationConfig as SprykerContentNavigationConfig;

class ContentNavigationConfig extends SprykerContentNavigationConfig
{
    /**
     * Content item navigation header template identifier.
     *
     * @var string
     */
    public const WIDGET_TEMPLATE_IDENTIFIER_LIST_NAVIGATION_HEADER = 'navigation-header';

    /**
     * Content item navigation header mobile template identifier.
     *
     * @var string
     */
    public const WIDGET_TEMPLATE_IDENTIFIER_LIST_NAVIGATION_HEADER_MOBILE = 'navigation-header-mobile';

    /**
     * Content item navigation footer template identifier.
     *
     * @var string
     */
    public const WIDGET_TEMPLATE_IDENTIFIER_LIST_NAVIGATION_FOOTER = 'navigation-footer';
}
