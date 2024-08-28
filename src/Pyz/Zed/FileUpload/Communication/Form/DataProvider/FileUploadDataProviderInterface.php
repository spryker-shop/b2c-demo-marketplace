<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Zed\FileUpload\Communication\Form\DataProvider;

interface FileUploadDataProviderInterface
{
    /**
     * @param array<string> $acceptedContentTypes
     *
     * @return array<string, mixed>
     */
    public function getOptions(array $acceptedContentTypes): array;
}
