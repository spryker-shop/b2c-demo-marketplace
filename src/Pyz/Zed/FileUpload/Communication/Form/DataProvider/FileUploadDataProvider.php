<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Zed\FileUpload\Communication\Form\DataProvider;

use Pyz\Zed\FileUpload\Communication\Form\FileUploadForm;
use Pyz\Zed\Merchant\Business\MerchantFacadeInterface;

class FileUploadDataProvider implements FileUploadDataProviderInterface
{
    private MerchantFacadeInterface $merchantFacade;

    public function __construct(MerchantFacadeInterface $merchantFacade)
    {
        $this->merchantFacade = $merchantFacade;
    }

    public function getOptions(array $acceptedContentTypes): array
    {
        return [
            FileUploadForm::OPTION_MERCHANT_CHOICES => $this->getMerchantChoices(),
            FileUploadForm::OPTION_ACCEPTED_CONTENT_TYPE => $acceptedContentTypes,
        ];
    }

    private function getMerchantChoices(): array
    {
        $activeMerchantNames = $this->merchantFacade->getActiveMerchantNamesWithIds();

        return array_flip($activeMerchantNames);
    }
}
