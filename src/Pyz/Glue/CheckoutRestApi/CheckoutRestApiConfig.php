<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\CheckoutRestApi;

use Generated\Shared\Transfer\RestCustomerTransfer;
use Spryker\Glue\CheckoutRestApi\CheckoutRestApiConfig as SprykerCheckoutRestApiConfig;

class CheckoutRestApiConfig extends SprykerCheckoutRestApiConfig
{
    /**
     * @var array<string, array<string>>
     */
    protected const PAYMENT_METHOD_REQUIRED_FIELDS = [
        'dummyPaymentCreditCard' => [
            'dummyPaymentCreditCard.cardType',
            'dummyPaymentCreditCard.cardNumber',
            'dummyPaymentCreditCard.nameOnCard',
            'dummyPaymentCreditCard.cardExpiresMonth',
            'dummyPaymentCreditCard.cardExpiresYear',
            'dummyPaymentCreditCard.cardSecurityCode',
        ],
        'dummyMarketplacePaymentInvoice' => ['dummyMarketplacePaymentInvoice.dateOfBirth'],
    ];

    /**
     * @uses \Spryker\Shared\DummyPayment\DummyPaymentConfig::PROVIDER_NAME
     *
     * @var string
     */
    protected const DUMMY_PAYMENT_PROVIDER_NAME = 'DummyPayment';

    /**
     * @uses \Spryker\Shared\DummyMarketplacePayment\DummyMarketplacePaymentConfig::PAYMENT_PROVIDER_NAME
     *
     * @var string
     */
    protected const DUMMY_MARKETPLACE_PAYMENT_PROVIDER_NAME = 'DummyMarketplacePayment';

    /**
     * @uses \Spryker\Shared\DummyPayment\DummyPaymentConfig::PAYMENT_METHOD_NAME_CREDIT_CARD
     *
     * @var string
     */
    protected const DUMMY_PAYMENT_PAYMENT_METHOD_NAME_CREDIT_CARD = 'Credit Card';

    /**
     * @var string
     */
    protected const DUMMY_PAYMENT_PAYMENT_METHOD_NAME_INVOICE = 'Invoice (Marketplace)';

    /**
     * @uses \Spryker\Shared\DummyPayment\DummyPaymentConfig::PAYMENT_METHOD_CREDIT_CARD
     *
     * @var string
     */
    protected const PAYMENT_METHOD_CREDIT_CARD = 'dummyPaymentCreditCard';

    /**
     * @uses \Spryker\Shared\DummyMarketplacePayment\DummyMarketplacePaymentConfig::PAYMENT_METHOD_DUMMY_MARKETPLACE_PAYMENT_INVOICE
     *
     * @var string
     */
    protected const PAYMENT_METHOD_DUMMY_MARKETPLACE_PAYMENT_INVOICE = 'dummyMarketplacePaymentInvoice';

    /**
     * @var bool
     */
    protected const IS_PAYMENT_PROVIDER_METHOD_TO_STATE_MACHINE_MAPPING_ENABLED = false;

    /**
     * @return array<array<string>>
     */
    public function getPaymentProviderMethodToStateMachineMapping(): array
    {
        return [
            static::DUMMY_PAYMENT_PROVIDER_NAME => [
                static::DUMMY_PAYMENT_PAYMENT_METHOD_NAME_CREDIT_CARD => static::PAYMENT_METHOD_CREDIT_CARD,
            ],
            static::DUMMY_MARKETPLACE_PAYMENT_PROVIDER_NAME => [
                static::DUMMY_PAYMENT_PAYMENT_METHOD_NAME_INVOICE => static::PAYMENT_METHOD_DUMMY_MARKETPLACE_PAYMENT_INVOICE,
            ],
        ];
    }

    /**
     * @return bool
     */
    public function isShipmentMethodsMappedToAttributes(): bool
    {
        return false;
    }

    /**
     * @return bool
     */
    public function isPaymentProvidersMappedToAttributes(): bool
    {
        return false;
    }

    /**
     * @return bool
     */
    public function isAddressesMappedToAttributes(): bool
    {
        return false;
    }

    /**
     * @return list<string>
     */
    public function getRequiredCustomerRequestDataForGuestCheckout(): array
    {
        return array_merge(parent::getRequiredCustomerRequestDataForGuestCheckout(), [
            RestCustomerTransfer::FIRST_NAME,
            RestCustomerTransfer::LAST_NAME,
        ]);
    }
}
