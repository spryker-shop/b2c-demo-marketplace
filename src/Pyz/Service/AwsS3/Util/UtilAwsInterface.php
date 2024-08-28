<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Service\AwsS3\Util;

interface UtilAwsInterface
{
    /**
     * @return void
     */
    public function registerStreamWrapper(): void;
}
