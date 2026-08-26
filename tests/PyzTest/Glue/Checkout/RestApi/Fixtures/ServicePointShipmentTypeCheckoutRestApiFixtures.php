<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace PyzTest\Glue\Checkout\RestApi\Fixtures;

use ArrayObject;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\ProductOfferStockTransfer;
use Generated\Shared\Transfer\ProductOfferTransfer;
use Generated\Shared\Transfer\ServicePointTransfer;
use Generated\Shared\Transfer\ServiceTransfer;
use Generated\Shared\Transfer\ShipmentMethodTransfer;
use Generated\Shared\Transfer\ShipmentTypeTransfer;
use Generated\Shared\Transfer\StockTransfer;
use Generated\Shared\Transfer\StoreRelationTransfer;
use Generated\Shared\Transfer\StoreTransfer;
use PyzTest\Glue\Checkout\CheckoutApiTester;
use SprykerTest\Shared\Shipment\Helper\ShipmentMethodDataHelper;
use SprykerTest\Shared\Testify\Fixtures\FixturesBuilderInterface;
use SprykerTest\Shared\Testify\Fixtures\FixturesContainerInterface;

class ServicePointShipmentTypeCheckoutRestApiFixtures implements FixturesBuilderInterface, FixturesContainerInterface
{
    /**
     * @var string
     */
    protected const TEST_USERNAME = 'ServicePointShipmentTypeCheckoutRestApiFixtures';

    /**
     * @var string
     */
    protected const TEST_PASSWORD = 'change123';

    protected CustomerTransfer $customerTransfer;

    protected ShipmentMethodTransfer $pickableShipmentMethodTransfer;

    protected ShipmentMethodTransfer $regularShipmentMethodTransfer;

    protected ServicePointTransfer $servicePointTransfer;

    protected ShipmentTypeTransfer $pickableShipmentTypeTransfer;

    protected StoreTransfer $storeTransfer;

    /**
     * @var list<\Generated\Shared\Transfer\ProductOfferTransfer>
     */
    protected array $productOfferTransfers;

    public function getCustomerTransfer(): CustomerTransfer
    {
        return $this->customerTransfer;
    }

    public function getPickableShipmentMethodTransfer(): ShipmentMethodTransfer
    {
        return $this->pickableShipmentMethodTransfer;
    }

    public function getRegularShipmentMethodTransfer(): ShipmentMethodTransfer
    {
        return $this->regularShipmentMethodTransfer;
    }

    public function getServicePointTransfer(): ServicePointTransfer
    {
        return $this->servicePointTransfer;
    }

    /**
     * @return list<\Generated\Shared\Transfer\ProductOfferTransfer>
     */
    public function getProductOfferTransfers(): array
    {
        return $this->productOfferTransfers;
    }

    public function buildFixtures(CheckoutApiTester $I): FixturesContainerInterface
    {
        $I->truncateSalesOrderThresholds();

        $this->createStore($I);
        $this->createCustomer($I);
        $this->createPickableShipmentType($I);
        $this->createShipmentMethods($I);
        $this->createServicePoint($I);
        $this->createProductOfferTransfers($I);

        return $this;
    }

    protected function createStore(CheckoutApiTester $I): void
    {
        $this->storeTransfer = $I->getStoreFacade()->getCurrentStore();
    }

    protected function createCustomer(CheckoutApiTester $I): void
    {
        $customerTransfer = $I->haveCustomer([
            CustomerTransfer::USERNAME => static::TEST_USERNAME,
            CustomerTransfer::PASSWORD => static::TEST_PASSWORD,
            CustomerTransfer::NEW_PASSWORD => static::TEST_PASSWORD,
        ]);

        $this->customerTransfer = $I->confirmCustomer($customerTransfer);
    }

    protected function createPickableShipmentType(CheckoutApiTester $I): void
    {
        $this->pickableShipmentTypeTransfer = $I->havePickableShipmentType($this->storeTransfer);
    }

    protected function createShipmentMethods(CheckoutApiTester $I): void
    {
        $this->pickableShipmentMethodTransfer = $I->haveShipmentMethod(
            [ShipmentMethodTransfer::IS_ACTIVE => true],
            [],
            ShipmentMethodDataHelper::DEFAULT_PRICE_LIST,
            [$this->storeTransfer->getIdStoreOrFail()],
        );
        $I->haveShipmentMethodShipmentTypeRelation(
            $this->pickableShipmentMethodTransfer->getIdShipmentMethod(),
            $this->pickableShipmentTypeTransfer->getIdShipmentType(),
        );

        $this->regularShipmentMethodTransfer = $I->haveShipmentMethod(
            [ShipmentMethodTransfer::IS_ACTIVE => true],
            [],
            ShipmentMethodDataHelper::DEFAULT_PRICE_LIST,
            [$this->storeTransfer->getIdStoreOrFail()],
        );
    }

    protected function createServicePoint(CheckoutApiTester $I): void
    {
        $this->servicePointTransfer = $I->haveServicePointWithAddress($this->storeTransfer);
    }

    protected function createProductOfferTransfers(CheckoutApiTester $I): void
    {
        $productConcreteTransfer1 = $I->haveProductWithStock();
        $productConcreteTransfer2 = $I->haveProductWithStock();

        $merchantTransfer = $I->haveMerchantWithStoreRelation($this->storeTransfer);
        $stockTransfer = $I->haveStock([
            StockTransfer::IS_ACTIVE => true,
            StockTransfer::STORE_RELATION => (new StoreRelationTransfer())->addIdStores($this->storeTransfer->getIdStoreOrFail()),
        ]);
        $serviceTransfer = $I->havePickableService($this->pickableShipmentTypeTransfer, [
            ServiceTransfer::SERVICE_POINT => $this->servicePointTransfer->toArray(),
            ServiceTransfer::IS_ACTIVE => true,
        ]);

        $this->productOfferTransfers[] = $I->haveProductOfferWithShipmentTypeAndServiceRelations(
            $productConcreteTransfer1,
            $serviceTransfer,
            $this->pickableShipmentTypeTransfer,
            [
                ProductOfferTransfer::MERCHANT_REFERENCE => $merchantTransfer->getMerchantReferenceOrFail(),
                ProductOfferTransfer::STORES => new ArrayObject([$this->storeTransfer]),
                ProductOfferStockTransfer::STOCK => $stockTransfer->toArray(),
            ],
        );
        $this->productOfferTransfers[] = $I->haveProductOfferWithShipmentTypeAndServiceRelations(
            $productConcreteTransfer2,
            $serviceTransfer,
            $this->pickableShipmentTypeTransfer,
            [
                ProductOfferTransfer::MERCHANT_REFERENCE => $merchantTransfer->getMerchantReferenceOrFail(),
                ProductOfferTransfer::STORES => new ArrayObject([$this->storeTransfer]),
                ProductOfferStockTransfer::STOCK => $stockTransfer->toArray(),
            ],
        );
    }
}
