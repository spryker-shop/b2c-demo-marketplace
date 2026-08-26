<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace PyzTest\Glue\Checkout\RestApi\Fixtures;

use ArrayObject;
use Generated\Shared\Transfer\CountryTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\ProductOfferStockTransfer;
use Generated\Shared\Transfer\ProductOfferTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\ServicePointAddressTransfer;
use Generated\Shared\Transfer\ServicePointTransfer;
use Generated\Shared\Transfer\ServiceTransfer;
use Generated\Shared\Transfer\ShipmentMethodTransfer;
use Generated\Shared\Transfer\StockTransfer;
use Generated\Shared\Transfer\StoreRelationTransfer;
use PyzTest\Glue\Checkout\CheckoutApiTester;
use SprykerTest\Shared\Shipment\Helper\ShipmentMethodDataHelper;
use SprykerTest\Shared\Testify\Fixtures\FixturesBuilderInterface;
use SprykerTest\Shared\Testify\Fixtures\FixturesContainerInterface;

class ServicePointShipmentTypeCheckoutDataRestApiFixtures implements FixturesBuilderInterface, FixturesContainerInterface
{
    /**
     * @var string
     */
    protected const TEST_USERNAME = 'CheckoutDataRestApiFixtures';

    /**
     * @var string
     */
    protected const TEST_PASSWORD = 'change123';

    protected CustomerTransfer $customerTransfer;

    protected QuoteTransfer $quoteTransfer;

    protected ShipmentMethodTransfer $pickableShipmentMethodTransfer;

    protected ShipmentMethodTransfer $nonPickableShipmentMethodTransfer;

    protected ServicePointTransfer $servicePointWithAddress;

    protected ServicePointTransfer $servicePoint;

    protected ServicePointTransfer $servicePointWithoutAddress;

    public function getQuoteTransfer(): QuoteTransfer
    {
        return $this->quoteTransfer;
    }

    public function getServicePointWithoutAddress(): ServicePointTransfer
    {
        return $this->servicePointWithoutAddress;
    }

    public function getCustomerTransfer(): CustomerTransfer
    {
        return $this->customerTransfer;
    }

    public function getPickableShipmentMethodTransfer(): ShipmentMethodTransfer
    {
        return $this->pickableShipmentMethodTransfer;
    }

    public function getNonPickableShipmentMethodTransfer(): ShipmentMethodTransfer
    {
        return $this->nonPickableShipmentMethodTransfer;
    }

    public function getServicePoint(): ServicePointTransfer
    {
        return $this->servicePoint;
    }

    public function getServicePointWithAddress(): ServicePointTransfer
    {
        return $this->servicePointWithAddress;
    }

    public function buildFixtures(CheckoutApiTester $I): FixturesContainerInterface
    {
        $I->truncateSalesOrderThresholds();

        $customerTransfer = $I->haveCustomer([
            CustomerTransfer::USERNAME => static::TEST_USERNAME,
            CustomerTransfer::PASSWORD => static::TEST_PASSWORD,
            CustomerTransfer::NEW_PASSWORD => static::TEST_PASSWORD,
        ]);

        $productConcreteTransfer1 = $I->haveProductWithStock();
        $productConcreteTransfer2 = $I->haveProductWithStock();

        $storeTransfer = $I->getStoreFacade()->getCurrentStore();
        $this->pickableShipmentMethodTransfer = $I->haveShipmentMethod(
            [
                ShipmentMethodTransfer::CARRIER_NAME => 'Spryker Dummy Shipment with pickable Shipment Type',
                ShipmentMethodTransfer::NAME => 'Standard with pickable Shipment Type',
            ],
            [],
            ShipmentMethodDataHelper::DEFAULT_PRICE_LIST,
            [$storeTransfer->getIdStoreOrFail()],
        );
        $pickableShipmentTypeTransfer = $I->havePickableShipmentType($storeTransfer);
        $I->addShipmentTypeToShipmentMethod($this->pickableShipmentMethodTransfer, $pickableShipmentTypeTransfer);

        $this->nonPickableShipmentMethodTransfer = $I->haveShipmentMethod(
            [
                ShipmentMethodTransfer::CARRIER_NAME => 'Spryker Dummy Shipment',
                ShipmentMethodTransfer::NAME => 'Standard',
            ],
            [],
            ShipmentMethodDataHelper::DEFAULT_PRICE_LIST,
            [$storeTransfer->getIdStoreOrFail()],
        );

        $this->servicePointWithoutAddress = $I->haveServicePointWithoutAddress($storeTransfer);

        $this->servicePoint = $I->haveServicePointWithAddress($storeTransfer);
        $serviceTransfer = $I->havePickableService($pickableShipmentTypeTransfer, [
            ServiceTransfer::SERVICE_POINT => $this->servicePoint->toArray(),
            ServiceTransfer::IS_ACTIVE => true,
        ]);

        $merchantTransfer = $I->haveMerchantWithStoreRelation($storeTransfer);
        $stockTransfer = $I->haveStock([
            StockTransfer::IS_ACTIVE => true,
            StockTransfer::STORE_RELATION => (new StoreRelationTransfer())->addIdStores($storeTransfer->getIdStoreOrFail()),
        ]);

        $productOfferTransfer1 = $I->haveProductOfferWithShipmentTypeAndServiceRelations(
            $productConcreteTransfer1,
            $serviceTransfer,
            $pickableShipmentTypeTransfer,
            [
                ProductOfferTransfer::MERCHANT_REFERENCE => $merchantTransfer->getMerchantReferenceOrFail(),
                ProductOfferTransfer::STORES => new ArrayObject([$storeTransfer]),
                ProductOfferStockTransfer::STOCK => $stockTransfer->toArray(),
            ],
        );
        $productOfferTransfer2 = $I->haveProductOfferWithShipmentTypeAndServiceRelations(
            $productConcreteTransfer2,
            $serviceTransfer,
            $pickableShipmentTypeTransfer,
            [
                ProductOfferTransfer::MERCHANT_REFERENCE => $merchantTransfer->getMerchantReferenceOrFail(),
                ProductOfferTransfer::STORES => new ArrayObject([$storeTransfer]),
                ProductOfferStockTransfer::STOCK => $stockTransfer->toArray(),
            ],
        );

        $countryTransfer = $I->haveCountry([
            CountryTransfer::ISO2_CODE => 'DE',
        ]);
        $this->servicePointWithAddress = $I->haveServicePoint(
            [
                ServicePointTransfer::STORE_RELATION => (new StoreRelationTransfer())->addStores($storeTransfer),
            ],
        );
        $servicePointAddressTransfer = $I->haveServicePointAddress(
            [
                ServicePointAddressTransfer::SERVICE_POINT => $this->servicePointWithAddress->toArray(),
                ServicePointAddressTransfer::COUNTRY => $countryTransfer->toArray(),
            ],
        );
        $this->servicePointWithAddress->setAddress($servicePointAddressTransfer);

        $this->customerTransfer = $I->confirmCustomer($customerTransfer);
        $this->quoteTransfer = $I->havePersistentQuoteWithProductOfferItems(
            $this->customerTransfer,
            [$productOfferTransfer1, $productOfferTransfer2],
        );

        return $this;
    }
}
