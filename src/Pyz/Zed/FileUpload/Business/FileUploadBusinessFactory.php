<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Zed\FileUpload\Business;

use Pyz\Service\AwsS3\AwsS3ServiceInterface;
use Pyz\Zed\FileUpload\Business\Builder\FileNameBuilder;
use Pyz\Zed\FileUpload\Business\Builder\FileNameBuilderInterface;
use Pyz\Zed\FileUpload\Business\Builder\Resolver\FileTypeResolver;
use Pyz\Zed\FileUpload\Business\Builder\Resolver\FileTypeResolverInterface;
use Pyz\Zed\FileUpload\Business\Deleter\FileUploadDeleter;
use Pyz\Zed\FileUpload\Business\Deleter\FileUploadDeleterInterface;
use Pyz\Zed\FileUpload\Business\Reader\FileUploadReader;
use Pyz\Zed\FileUpload\Business\Reader\FileUploadReaderInterface;
use Pyz\Zed\FileUpload\Business\Writer\FileUploadWriter;
use Pyz\Zed\FileUpload\Business\Writer\FileUploadWriterInterface;
use Pyz\Zed\FileUpload\FileUploadDependencyProvider;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use Spryker\Zed\MerchantUser\Business\MerchantUserFacadeInterface;

/**
 * @method \Pyz\Zed\FileUpload\FileUploadConfig getConfig()
 * @method \Pyz\Zed\FileUpload\Persistence\FileUploadEntityManagerInterface getEntityManager()
 * @method \Pyz\Zed\FileUpload\Persistence\FileUploadRepositoryInterface getRepository()
 */
class FileUploadBusinessFactory extends AbstractBusinessFactory
{
    public function createFileNameBuilder(): FileNameBuilderInterface
    {
        return new FileNameBuilder(
            $this->createFileTypeResolver(),
            $this->getMerchantUserFacade(),
            $this->getConfig(),
        );
    }

    public function createFileUploadReader(): FileUploadReaderInterface
    {
        return new FileUploadReader(
            $this->getRepository(),
        );
    }

    public function createFileUploadWriter(): FileUploadWriterInterface
    {
        return new FileUploadWriter(
            $this->getEntityManager(),
            $this->getMerchantUserFacade(),
            $this->getAwsS3Service(),
            $this->getFileUploadPostSavePlugins(),
        );
    }

    public function createFileUploadDeleter(): FileUploadDeleterInterface
    {
        return new FileUploadDeleter(
            $this->getEntityManager(),
        );
    }

    public function createFileTypeResolver(): FileTypeResolverInterface
    {
        return new FileTypeResolver($this->getConfig());
    }

    private function getMerchantUserFacade(): MerchantUserFacadeInterface
    {
        return $this->getProvidedDependency(FileUploadDependencyProvider::FACADE_MERCHANT_USER);
    }

    private function getAwsS3Service(): AwsS3ServiceInterface
    {
        return $this->getProvidedDependency(FileUploadDependencyProvider::SERVICE_AWS_S3);
    }

    /**
     * @return array<\Pyz\Zed\FileUpload\Dependency\Plugin\FileUploadPostSavePluginInterface>
     */
    private function getFileUploadPostSavePlugins(): array
    {
        return $this->getProvidedDependency(FileUploadDependencyProvider::PLUGINS_FILE_UPLOAD_POST_SAVE);
    }
}
