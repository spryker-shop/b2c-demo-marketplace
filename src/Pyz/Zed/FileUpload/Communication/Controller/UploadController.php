<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Zed\FileUpload\Communication\Controller;

use Generated\Shared\Transfer\FileUploadTransfer;
use Generated\Shared\Transfer\MerchantCriteriaTransfer;
use Generated\Shared\Transfer\MerchantTransfer;
use Pyz\Shared\AwsS3\AwsS3Config as SharedAwsS3Config;
use Pyz\Shared\FileUpload\FileUploadConfig as SharedFileUploadConfig;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Pyz\Zed\FileUpload\Communication\FileUploadCommunicationFactory getFactory()
 * @method \Pyz\Zed\FileUpload\Persistence\FileUploadRepositoryInterface getRepository()
 * @method \Pyz\Zed\FileUpload\Business\FileUploadFacadeInterface getFacade()
 */
class UploadController extends AbstractController
{
    private const PARAM_FILE_NAME = 'fileName';

    private const PARAM_FILE_URL = 'fileUrl';

    private const PARAM_FILE_SIZE = 'fileSize';

    private const PARAM_FILE_TYPE = 'fileType';

    private const PARAM_ID_MERCHANT = 'idMerchant';

    private const PARAM_ORIGINAL_FILE_NAME = 'originalFileName';

    private const ERROR_FORM_NOT_SUBMITTED = 'Form was not submitted!';

    private const ERROR_MERCHANT_NOT_FOUND = 'Selected merchant not found!';

    public function indexAction(): array
    {
        $fileUploadForm = $this->getFileUploadForm(SharedFileUploadConfig::ACCEPTED_IMAGE_CONTENT_TYPES);

        return [
            'form' => $fileUploadForm->createView(),
        ];
    }

    public function getImageUploadUrlAction(Request $request): JsonResponse
    {
        $formOptions = $this->getFactory()
            ->createFileUploadDataProvider()
            ->getOptions(SharedFileUploadConfig::ACCEPTED_IMAGE_CONTENT_TYPES);
        $fileUploadForm = $this->getFactory()
            ->createFileUploadForm($formOptions)
            ->handleRequest($request);

        if (!$fileUploadForm->isSubmitted()) {
            return $this->getJsonErrorResponse([self::ERROR_FORM_NOT_SUBMITTED]);
        }

        if (!$fileUploadForm->isValid()) {
            $errorMessages = $this->getFormErrorMessages($fileUploadForm);

            return $this->getJsonErrorResponse($errorMessages);
        }

        /** @var \Generated\Shared\Transfer\FileUploadTransfer $formUploadTransfer */
        $formUploadTransfer = $fileUploadForm->getData();
        $merchantTransfer = $this->findMerchantById($formUploadTransfer->getFkMerchant());
        if (!$merchantTransfer) {
            return $this->getJsonErrorResponse([self::ERROR_MERCHANT_NOT_FOUND]);
        }

        $uploadFileName = $this->getFacade()->buildUploadFileNameForMerchant(
            $formUploadTransfer->getOriginalFileName(),
            $formUploadTransfer->getContentType(),
            $merchantTransfer->getMerchantReference(),
        );

        $preSignedUrl = $this->getFactory()
            ->getAwsS3Service()
            ->getPresignedUrl($uploadFileName, SharedAwsS3Config::OBJECT_TYPE_ADDITIONAL_MEDIA);

        return $this->jsonResponse([
            self::PARAM_FILE_URL => $preSignedUrl,
            self::PARAM_FILE_NAME => $uploadFileName,
            self::PARAM_ID_MERCHANT => $merchantTransfer->getIdMerchant(),
        ]);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function saveImageUploadDataAction(Request $request): JsonResponse
    {
        $fileUploadTransfer = $this->createHydratedFileUploadTransferForImage($request);

        $fileUploadTransfer = $this->getFacade()
            ->createFileUpload($fileUploadTransfer);

        return $this->jsonResponse([
            'success' => true,
            'cdnUrl' => $fileUploadTransfer->getCdnUrl(),
        ]);
    }

    /**
     * @param array<string> $acceptedContentType
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    private function getFileUploadForm(array $acceptedContentType): FormInterface
    {
        $formOptions = $this->getFactory()
            ->createFileUploadDataProvider()
            ->getOptions($acceptedContentType);

        return $this->getFactory()
            ->createFileUploadForm($formOptions);
    }

    /**
     * @param array<string> $errorMessages
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    private function getJsonErrorResponse(array $errorMessages): JsonResponse
    {
        return $this->jsonResponse(
            [
                'errors' => $errorMessages,
            ],
            JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
        );
    }

    private function createHydratedFileUploadTransferForImage(Request $request): FileUploadTransfer
    {
        $fileName = $request->get(self::PARAM_FILE_NAME);
        $size = $request->get(self::PARAM_FILE_SIZE);
        $type = $request->get(self::PARAM_FILE_TYPE);
        $originalName = $request->get(self::PARAM_ORIGINAL_FILE_NAME);
        $idMerchant = $request->get(self::PARAM_ID_MERCHANT);
        $idUser = $this->getFactory()->getUserFacade()->getCurrentUser()->getIdUser();

        return (new FileUploadTransfer())
            ->setOriginalFileName($originalName)
            ->setFileName($fileName)
            ->setContentType($type)
            ->setSize($size)
            ->setFkMerchant($idMerchant)
            ->setFkUser($idUser)
            ->setObjectType(SharedAwsS3Config::OBJECT_TYPE_ADDITIONAL_MEDIA);
    }

    /**
     * @param \Symfony\Component\Form\FormInterface $form
     *
     * @return array<string>
     */
    private function getFormErrorMessages(FormInterface $form): array
    {
        $formErrorIterator = $form->getErrors(true);
        $errorMessages = [];
        foreach ($formErrorIterator as $formError) {
            $errorMessages[] = $formError->getMessage();
        }

        return $errorMessages;
    }

    private function findMerchantById(int $idMerchant): ?MerchantTransfer
    {
        $merchantCriteriaTransfer = $this->createMerchantCriteriaTransfer()->setIdMerchant($idMerchant);

        return $this->getFactory()->getMerchantFacade()->findOne($merchantCriteriaTransfer);
    }

    private function createMerchantCriteriaTransfer(): MerchantCriteriaTransfer
    {
        return new MerchantCriteriaTransfer();
    }
}
