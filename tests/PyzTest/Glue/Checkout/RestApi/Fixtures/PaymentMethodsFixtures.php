<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace PyzTest\Glue\Checkout\RestApi\Fixtures;

use Generated\Shared\Transfer\PaymentMethodTransfer;
use Generated\Shared\Transfer\PaymentProviderTransfer;
use PyzTest\Glue\Checkout\CheckoutApiTester;
use SprykerTest\Shared\Testify\Fixtures\FixturesBuilderInterface;
use SprykerTest\Shared\Testify\Fixtures\FixturesContainerInterface;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Glue
 * @group Checkout
 * @group RestApi
 * @group PaymentMethodsFixtures
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class PaymentMethodsFixtures implements FixturesBuilderInterface, FixturesContainerInterface
{
    /**
     * @param \PyzTest\Glue\Checkout\CheckoutApiTester $I
     *
     * @return \SprykerTest\Shared\Testify\Fixtures\FixturesContainerInterface
     */
    public function buildFixtures(CheckoutApiTester $I): FixturesContainerInterface
    {
        $paymentProviderTransfer = $I->havePaymentProvider([
            PaymentProviderTransfer::PAYMENT_PROVIDER_KEY => 'DummyMarketplacePayment',
            PaymentProviderTransfer::NAME => 'Dummy Marketplace Payment',
        ]);
        $I->havePaymentMethodWithStore([
            PaymentMethodTransfer::IS_ACTIVE => true,
            PaymentMethodTransfer::PAYMENT_METHOD_KEY => 'dummyMarketplacePaymentInvoice',
            PaymentMethodTransfer::NAME => 'Invoice (Marketplace)',
            PaymentMethodTransfer::ID_PAYMENT_PROVIDER => $paymentProviderTransfer->getIdPaymentProvider(),
        ]);

        return $this;
    }
}
