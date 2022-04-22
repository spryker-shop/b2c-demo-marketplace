<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Acl\Business\Model;

interface PyzInstallerInterface
{
    /**
     * Main Installation Method
     *
     * @return void
     */
    public function install(): void;
}
