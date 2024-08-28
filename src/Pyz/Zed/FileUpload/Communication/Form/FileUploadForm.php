<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Zed\FileUpload\Communication\Form;

use Generated\Shared\Transfer\FileUploadTransfer;
use Pyz\Zed\FileUpload\FileUploadConfig;
use Spryker\Zed\Kernel\Communication\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @method \Pyz\Zed\FileUpload\Communication\FileUploadCommunicationFactory getFactory()
 * @method \Pyz\Zed\FileUpload\FileUploadConfig getConfig()
 * @method \Pyz\Zed\FileUpload\Persistence\FileUploadRepositoryInterface getRepository()
 * @method \Pyz\Zed\FileUpload\Business\FileUploadFacadeInterface getFacade()
 */
class FileUploadForm extends AbstractType
{
    public const FIELD_FILE_NAME = FileUploadTransfer::ORIGINAL_FILE_NAME;

    public const FIELD_MERCHANT = FileUploadTransfer::FK_MERCHANT;

    public const FIELD_CONTENT_TYPE = FileUploadTransfer::CONTENT_TYPE;

    public const OPTION_MERCHANT_CHOICES = 'option_merchant_choices';

    public const OPTION_ACCEPTED_CONTENT_TYPE = 'accepted_content_type';

    private const ERROR_FILE_NAME_NOT_PROVIDED = 'File name not provided!';

    private const ERROR_CONTENT_TYPE_NOT_PROVIDED = 'Content type not provided!';

    private const ERROR_MERCHANT_NOT_SELECTED = 'Related merchant not selected!';

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);

        $this->addFileNameField($builder);
        $this->addContentTypeField($builder);
        $this->addMerchantField($builder, $options);

        $builder->setAction(FileUploadConfig::URL_GET_IMAGE_UPLOAD_URL);
    }

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'data_class' => FileUploadTransfer::class,
        ]);

        $resolver->setRequired([
            self::OPTION_ACCEPTED_CONTENT_TYPE,
            self::OPTION_MERCHANT_CHOICES,
        ]);
    }

    /**
     * @param \Symfony\Component\Form\FormView $view
     * @param \Symfony\Component\Form\FormInterface $form
     * @param array $options
     *
     * @return void
     */
    public function finishView(FormView $view, FormInterface $form, array $options): void
    {
        parent::finishView($view, $form, $options);

        $view->vars[self::OPTION_ACCEPTED_CONTENT_TYPE] = $options[self::OPTION_ACCEPTED_CONTENT_TYPE];
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return void
     */
    private function addFileNameField(FormBuilderInterface $builder): void
    {
        $builder->add(self::FIELD_FILE_NAME, HiddenType::class, [
            'constraints' => [
                new NotBlank(['message' => self::ERROR_FILE_NAME_NOT_PROVIDED]),
            ],
        ]);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return void
     */
    private function addContentTypeField(FormBuilderInterface $builder): void
    {
        $builder->add(self::FIELD_CONTENT_TYPE, HiddenType::class, [
            'constraints' => [
                new NotBlank(['message' => self::ERROR_CONTENT_TYPE_NOT_PROVIDED]),
            ],
        ]);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     *
     * @return void
     */
    private function addMerchantField(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(self::FIELD_MERCHANT, ChoiceType::class, [
            'required' => true,
            'label' => 'Merchant',
            'choices' => $options[self::OPTION_MERCHANT_CHOICES],
            'constraints' => [
                new NotBlank(['message' => self::ERROR_MERCHANT_NOT_SELECTED]),
            ],
        ]);
    }
}
