<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace PyzTest\Yves\Customer\Helper;

use Codeception\Module;
use Codeception\Stub;
use Codeception\TestInterface;
use Generated\Shared\DataBuilder\CustomerBuilder;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\NewsletterSubscriberTransfer;
use Generated\Shared\Transfer\NewsletterSubscriptionRequestTransfer;
use Generated\Shared\Transfer\NewsletterTypeTransfer;
use Orm\Zed\Country\Persistence\SpyCountryQuery;
use Orm\Zed\Customer\Persistence\SpyCustomer;
use Orm\Zed\Customer\Persistence\SpyCustomerAddress;
use Orm\Zed\Customer\Persistence\SpyCustomerQuery;
use PyzTest\Yves\Customer\PageObject\Customer;
use PyzTest\Yves\Customer\PageObject\CustomerAddressesPage;
use PyzTest\Yves\Customer\PageObject\CustomerLoginPage;
use Spryker\Client\Session\SessionClient;
use Spryker\Shared\Newsletter\NewsletterConstants;
use Spryker\Zed\Customer\Business\CustomerFacadeInterface;
use Spryker\Zed\Customer\CustomerDependencyProvider;
use Spryker\Zed\Customer\Dependency\Facade\CustomerToMailBridge;
use Spryker\Zed\Mail\Business\MailFacadeInterface;
use Spryker\Zed\Newsletter\Business\NewsletterFacade;
use SprykerTest\Shared\Testify\Helper\DependencyHelperTrait;
use SprykerTest\Shared\Testify\Helper\LocatorHelperTrait;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;

class CustomerHelper extends Module
{
    use DependencyHelperTrait;
    use LocatorHelperTrait;

    /**
     * @param \Codeception\TestInterface $step
     *
     * @return void
     */
    public function _before(TestInterface $step): void // phpcs:ignore SlevomatCodingStandard.Functions.UnusedParameter
    {
        $this->cleanUpDatabase();
    }

    /**
     * @return void
     */
    protected function cleanUpDatabase(): void
    {
        $customer = [
            Customer::NEW_CUSTOMER_EMAIL,
            Customer::REGISTERED_CUSTOMER_EMAIL,
        ];

        foreach ($customer as $customerEmail) {
            $this->deleteCustomerByEmail($customerEmail);
        }
    }

    /**
     * @param string $email
     *
     * @return void
     */
    protected function deleteCustomerByEmail(string $email): void
    {
        $customerEntity = $this->loadCustomerByEmail($email);
        if (!$customerEntity) {
            return;
        }

        $this->deleteCustomerAddresses($customerEntity);
        $this->deleteNewsletterSubscription($customerEntity);

        $customerEntity->delete();
    }

    /**
     * @param \Orm\Zed\Customer\Persistence\SpyCustomer $customerEntity
     *
     * @return void
     */
    protected function deleteCustomerAddresses(SpyCustomer $customerEntity): void
    {
        $addresses = $customerEntity->getAddresses();
        if (!$addresses) {
            return;
        }

        $addresses->delete();
    }

    /**
     * @param \Orm\Zed\Customer\Persistence\SpyCustomer $customerEntity
     *
     * @return void
     */
    protected function deleteNewsletterSubscription(SpyCustomer $customerEntity): void
    {
        $newsletterSubscriptions = $customerEntity->getSpyNewsletterSubscribers();
        if (!$newsletterSubscriptions) {
            return;
        }

        foreach ($newsletterSubscriptions as $newsletterSubscription) {
            foreach ($newsletterSubscription->getSpyNewsletterSubscriptions() as $spyNewsletterSubscription) {
                $spyNewsletterSubscription->delete();
            }
            $newsletterSubscription->delete();
        }
    }

    /**
     * @param string $email
     *
     * @return \Orm\Zed\Customer\Persistence\SpyCustomer|null
     */
    public function loadCustomerByEmail(string $email): ?SpyCustomer
    {
        $customerQuery = new SpyCustomerQuery();

        return $customerQuery->findOneByEmail($email);
    }

    /**
     * @param array $seed
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    public function haveRegisteredCustomer(array $seed = []): CustomerTransfer
    {
        $this->setupSession();

        $customerBuilder = new CustomerBuilder($seed);
        $customerTransfer = $customerBuilder->build();
        $password = $customerTransfer->getPassword();

        $mailMock = new CustomerToMailBridge($this->getMailMock());
        $this->setDependency(CustomerDependencyProvider::FACADE_MAIL, $mailMock);
        $this->getFacade()->registerCustomer($customerTransfer);
        $this->getFacade()->confirmCustomerRegistration($customerTransfer);

        $customerTransfer->setPassword($password);

        return $customerTransfer;
    }

    /**
     * @return \Spryker\Zed\Customer\Business\CustomerFacadeInterface
     */
    private function getFacade(): CustomerFacadeInterface
    {
        return $this->getLocator()->customer()->facade();
    }

    /**
     * @return \Spryker\Zed\Mail\Business\MailFacadeInterface|object
     */
    private function getMailMock()
    {
        return Stub::makeEmpty(MailFacadeInterface::class);
    }

    /**
     * @param string $email
     * @param string $address
     * @param bool $isDefaultShipping
     * @param bool $isDefaultBilling
     *
     * @return void
     */
    public function addAddressToCustomer(string $email, string $address, bool $isDefaultShipping = true, bool $isDefaultBilling = true): void
    {
        $customerEntity = $this->loadCustomerByEmail($email);
        $addressTransfer = CustomerAddressesPage::getAddressData($address);

        $countryQuery = new SpyCountryQuery();
        $countryEntity = $countryQuery->findOneByIso2Code($addressTransfer->getIso2Code());

        $customerAddressEntity = new SpyCustomerAddress();
        $customerAddressEntity->fromArray($addressTransfer->toArray());
        $customerAddressEntity->setFkCountry($countryEntity->getIdCountry());
        $customerEntity->addAddress($customerAddressEntity);

        if ($isDefaultShipping) {
            $customerEntity->setShippingAddress($customerAddressEntity);
        }
        if ($isDefaultBilling) {
            $customerEntity->setBillingAddress($customerAddressEntity);
        }

        $customerEntity->save();
    }

    /**
     * @param string $email
     * @param string $type
     *
     * @return void
     */
    public function addNewsletterSubscription(string $email, string $type = NewsletterConstants::DEFAULT_NEWSLETTER_TYPE): void
    {
        $customerEntity = $this->loadCustomerByEmail($email);
        $newsletterSubscriberTransfer = new NewsletterSubscriberTransfer();
        $newsletterSubscriberTransfer->setEmail($email);
        $newsletterSubscriberTransfer->setFkCustomer($customerEntity->getIdCustomer());

        $newsletterSubscriptionType = new NewsletterTypeTransfer();
        $newsletterSubscriptionType->setName($type);

        $newsletterSubscriptionRequestTransfer = new NewsletterSubscriptionRequestTransfer();
        $newsletterSubscriptionRequestTransfer->setNewsletterSubscriber($newsletterSubscriberTransfer);
        $newsletterSubscriptionRequestTransfer->addSubscriptionType($newsletterSubscriptionType);

        $newsletterFacade = new NewsletterFacade();
        $newsletterFacade->subscribeWithDoubleOptIn($newsletterSubscriptionRequestTransfer);
    }

    /**
     * @param array $seed
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    public function amLoggedInCustomer(array $seed = []): CustomerTransfer
    {
        $customerTransfer = $this->haveRegisteredCustomer($seed);

        $tester = $this->getWebDriver();
        $tester->amOnPage(CustomerLoginPage::URL);
        $tester->submitForm(['name' => 'loginForm'], [
            CustomerLoginPage::FORM_FIELD_SELECTOR_EMAIL => $customerTransfer->getEmail(),
            CustomerLoginPage::FORM_FIELD_SELECTOR_PASSWORD => $customerTransfer->getPassword(),
        ]);

        $tester->wait(2);

        return $customerTransfer;
    }

    /**
     * @return \Codeception\Module|\Codeception\Module\WebDriver
     */
    protected function getWebDriver()
    {
        return $this->getModule('WebDriver');
    }

    /**
     * @return void
     */
    protected function setupSession(): void
    {
        $sessionContainer = new Session(new MockArraySessionStorage());
        $sessionClient = new SessionClient();
        $sessionClient->setContainer($sessionContainer);
    }
}
