<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Zed\FileUpload\Communication;

use Pyz\Service\AwsS3\AwsS3ServiceInterface;
use Pyz\Zed\FileUpload\Communication\Form\DataProvider\FileUploadDataProvider;
use Pyz\Zed\FileUpload\Communication\Form\DataProvider\FileUploadDataProviderInterface;
use Pyz\Zed\FileUpload\Communication\Form\FileUploadForm;
use Pyz\Zed\FileUpload\FileUploadDependencyProvider;
use Pyz\Zed\Merchant\Business\MerchantFacadeInterface;
use Pyz\Zed\User\Business\UserFacadeInterface;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use Symfony\Component\Form\FormInterface;

/**
 * @method \Pyz\Zed\FileUpload\Persistence\FileUploadEntityManagerInterface getEntityManager()
 * @method \Pyz\Zed\FileUpload\FileUploadConfig getConfig()
 * @method \Pyz\Zed\FileUpload\Persistence\FileUploadRepositoryInterface getRepository()
 * @method \Pyz\Zed\FileUpload\Business\FileUploadFacadeInterface getFacade()
 */
class FileUploadCommunicationFactory extends AbstractCommunicationFactory
{
    public function createFileUploadForm(array $options): FormInterface
    {
        return $this->getFormFactory()->create(FileUploadForm::class, null, $options);
    }

    public function createFileUploadDataProvider(): FileUploadDataProviderInterface
    {
        return new FileUploadDataProvider($this->getMerchantFacade());
    }

    public function getUserFacade(): UserFacadeInterface
    {
        return $this->getProvidedDependency(FileUploadDependencyProvider::FACADE_USER);
    }

    public function getMerchantFacade(): MerchantFacadeInterface
    {
        return $this->getProvidedDependency(FileUploadDependencyProvider::FACADE_MERCHANT);
    }

    public function getAwsS3Service(): AwsS3ServiceInterface
    {
        return $this->getProvidedDependency(FileUploadDependencyProvider::SERVICE_AWS_S3);
    }
}
