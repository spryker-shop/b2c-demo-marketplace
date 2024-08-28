<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\FileUploadMerchantPortalGui\Communication\Controller;

use Exception;
use Generated\Shared\Transfer\FileUploadCriteriaTransfer;
use Pyz\Shared\AwsS3\AwsS3Config;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Pyz\Zed\FileUploadMerchantPortalGui\Persistence\FileUploadMerchantPortalGuiRepositoryInterface getRepository()
 * @method \Pyz\Zed\FileUploadMerchantPortalGui\Communication\FileUploadMerchantPortalGuiCommunicationFactory getFactory()
 */
class DeleteController extends AbstractController
{
    private const PARAM_ID_FILE_UPLOAD = 'idFileUpload';

    private const ERROR_MESSAGE_FILE_NOT_FOUND = 'File not found.';

    private const ERROR_MESSAGE_FAILED_TO_DELETE_FILE = 'Failed to delete the file.';

    private const SUCCESS_MESSAGE_FILE_DELETED = 'Your selected file has been deleted from the marketplace.';

    public function indexAction(Request $request): JsonResponse
    {
        $idFileUpload = $this->castId($request->get(self::PARAM_ID_FILE_UPLOAD));

        $fileUploadCriteriaTransfer = (new FileUploadCriteriaTransfer())
            ->setIdFileUpload($idFileUpload);

        $fileUploadTransfer = $this->getFactory()
            ->getFileUploadFacade()
            ->findFileUpload($fileUploadCriteriaTransfer);

        $zedUiFormResponseBuilder = $this->getFactory()
            ->getZedUiFactory()
            ->createZedUiFormResponseBuilder();

        if (!$fileUploadTransfer) {
            $zedUiFormResponseBuilder->addErrorNotification(self::ERROR_MESSAGE_FILE_NOT_FOUND);

            return $this->jsonResponse($zedUiFormResponseBuilder->createResponse()->toArray());
        }

        try {
            $this->getFactory()
                ->getAwsS3Service()
                ->deleteS3Object(AwsS3Config::OBJECT_TYPE_ADDITIONAL_MEDIA, $fileUploadTransfer->getS3Url());

            $this->getFactory()->getFileUploadFacade()->deleteFileUpload($fileUploadTransfer);

            $zedUiFormResponseBuilder->addActionRefreshTable();
            $zedUiFormResponseBuilder->addSuccessNotification(self::SUCCESS_MESSAGE_FILE_DELETED);
        } catch (Exception) {
            $zedUiFormResponseBuilder->addErrorNotification(self::ERROR_MESSAGE_FAILED_TO_DELETE_FILE);
        }

        return $this->jsonResponse($zedUiFormResponseBuilder->createResponse()->toArray());
    }
}
