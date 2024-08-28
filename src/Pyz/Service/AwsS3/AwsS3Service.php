<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Service\AwsS3;

use Pyz\Shared\AwsS3\AwsS3Config as SharedAwsS3Config;
use Spryker\Service\Kernel\AbstractService;

/**
 * @method \Pyz\Service\AwsS3\AwsS3ServiceFactory getFactory()
 */
class AwsS3Service extends AbstractService implements AwsS3ServiceInterface
{
    public function getPresignedUrl(string $fileName, string $objectType): string
    {
        return $this->getFactory()
            ->createUrlCreator($objectType)
            ->getPresignedUrl($fileName);
    }

    public function getS3ObjectUrl(string $fileName, string $objectType): string
    {
        return $this->getFactory()
            ->createAwsS3ObjectReader($objectType)
            ->getS3ObjectUrl($fileName);
    }

    /**
     * @param string $objectType
     *
     * @return void
     */
    public function registerStreamWrapper(string $objectType = SharedAwsS3Config::OBJECT_TYPE_CVS_IMPORT): void
    {
        $this->getFactory()
            ->createUtilAws($objectType)
            ->registerStreamWrapper();
    }

    public function getCdnUrl(string $fileName, string $objectType): string
    {
        return $this->getFactory()
            ->createUrlCreator($objectType)
            ->getCdnUrl($fileName);
    }

    public function deleteS3Object(string $objectType, string $path): void
    {
        $this->getFactory()
            ->createAwsS3ObjectDeleter($objectType)
            ->deleteS3Object($path);
    }
}
