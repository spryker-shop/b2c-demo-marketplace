<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Zed\FileUploadMerchantPortalGui\Communication\Controller;

use Generated\Shared\Transfer\FileUploadTransfer;
use Pyz\Shared\AwsS3\AwsS3Config as SharedAwsS3Config;
use Pyz\Shared\FileUpload\FileUploadConfig;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Pyz\Zed\FileUploadMerchantPortalGui\Communication\FileUploadMerchantPortalGuiCommunicationFactory getFactory()
 * @method \Pyz\Zed\FileUploadMerchantPortalGui\Persistence\FileUploadMerchantPortalGuiRepositoryInterface getRepository()
 */
class UploadController extends AbstractController
{
    private const PARAM_FILE_NAME = 'fileName';

    private const PARAM_FILE_SIZE = 'fileSize';

    private const PARAM_FILE_CONTENT_TYPE = 'fileContentType';

    private const PARAM_ORIGINAL_FILE_NAME = 'originalFileName';

    private const ERROR_MISSING_FILE_DATA = 'Missing file data!';

    public function getUploadUrlAction(Request $request): JsonResponse
    {
        $originalFileName = $request->get(self::PARAM_FILE_NAME);
        $fileContentType = $request->get(self::PARAM_FILE_CONTENT_TYPE);
        if (!$originalFileName || !$fileContentType) {
            return $this->createErrorJsonResponse(self::ERROR_MISSING_FILE_DATA);
        }

        $uploadFileName = $this->getFactory()->getFileUploadFacade()
            ->buildUploadFileNameForCurrentMerchant($originalFileName, $fileContentType);
        $preSignedUrl = $this->getFactory()
            ->getAwsS3Service()
            ->getPresignedUrl($uploadFileName, SharedAwsS3Config::OBJECT_TYPE_ADDITIONAL_MEDIA);

        return $this->jsonResponse([
            'fileUrl' => $preSignedUrl,
            'fileName' => $uploadFileName,
        ]);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function saveUploadDataAction(Request $request): JsonResponse
    {
        $fileUploadTransfer = $this->createHydratedFileUploadTransfer($request);

        $fileUploadTransfer = $this->getFactory()
            ->getFileUploadFacade()
            ->createFileUpload($fileUploadTransfer);

        return $this->jsonResponse([
            'success' => true,
            'cdnUrl' => $fileUploadTransfer->getCdnUrl(),
        ]);
    }

    private function resolveResourceObjectType(string $contentType): string
    {
        if (in_array($contentType, array_merge(
            FileUploadConfig::ACCEPTED_DOCUMENT_CONTENT_TYPES,
            FileUploadConfig::ACCEPTED_IMAGE_CONTENT_TYPES,
            FileUploadConfig::ACCEPTED_VIDEO_CONTENT_TYPES,
        ))) {
            return SharedAwsS3Config::OBJECT_TYPE_ADDITIONAL_MEDIA;
        }

        return SharedAwsS3Config::OBJECT_TYPE_CVS_IMPORT;
    }

    private function createHydratedFileUploadTransfer(Request $request): FileUploadTransfer
    {
        $fileName = $request->get(self::PARAM_FILE_NAME);
        $size = $request->get(self::PARAM_FILE_SIZE);
        $type = $request->get(self::PARAM_FILE_CONTENT_TYPE);
        $originalName = $request->get(self::PARAM_ORIGINAL_FILE_NAME);

        return (new FileUploadTransfer())
            ->setOriginalFileName($originalName)
            ->setFileName($fileName)
            ->setContentType($type)
            ->setSize($size)
            ->setObjectType($this->resolveResourceObjectType($type));
    }

    private function createErrorJsonResponse(string $message): JsonResponse
    {
        $zedUiFormResponseTransfer = $this->getFactory()
            ->getZedUiFactory()
            ->createZedUiFormResponseBuilder()
            ->addErrorNotification($message)
            ->createResponse();

        return $this->jsonResponse($zedUiFormResponseTransfer->toArray());
    }
}
