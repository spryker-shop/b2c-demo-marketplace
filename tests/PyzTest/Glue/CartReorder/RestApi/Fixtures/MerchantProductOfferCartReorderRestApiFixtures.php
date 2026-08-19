<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace PyzTest\Glue\CartReorder\RestApi\Fixtures;

use ArrayObject;
use Generated\Shared\DataBuilder\ItemBuilder;
use Generated\Shared\DataBuilder\MerchantBuilder;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\MerchantTransfer;
use Generated\Shared\Transfer\ProductConcreteTransfer;
use Generated\Shared\Transfer\ProductOfferStockTransfer;
use Generated\Shared\Transfer\ProductOfferTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SaveOrderTransfer;
use Generated\Shared\Transfer\StockTransfer;
use Generated\Shared\Transfer\StoreRelationTransfer;
use Generated\Shared\Transfer\StoreTransfer;
use PyzTest\Glue\CartReorder\CartReorderApiTester;
use SprykerTest\Shared\Testify\Fixtures\FixturesBuilderInterface;
use SprykerTest\Shared\Testify\Fixtures\FixturesContainerInterface;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Glue
 * @group CartReorder
 * @group RestApi
 * @group MerchantProductOfferCartReorderRestApiFixtures
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class MerchantProductOfferCartReorderRestApiFixtures implements FixturesBuilderInterface, FixturesContainerInterface
{
    /**
     * @var string
     */
    protected const TEST_USERNAME = 'MerchantProductOfferCartReorderRestApiFixtures';

    /**
     * @uses \Spryker\Zed\Merchant\MerchantConfig::STATUS_APPROVED
     *
     * @var string
     */
    protected const MERCHANT_STATUS_APPROVED = 'approved';

    protected StoreTransfer $storeTransfer;

    protected CustomerTransfer $customerTransfer;

    protected MerchantTransfer $merchantTransfer;

    protected ProductConcreteTransfer $productConcreteTransfer;

    protected ProductConcreteTransfer $productConcreteTransferWithMerchantProductOffer;

    protected ProductOfferTransfer $productOfferTransfer;

    protected SaveOrderTransfer $orderWithMerchantProductOffer;

    public function getCustomerTransfer(): CustomerTransfer
    {
        return $this->customerTransfer;
    }

    public function getMerchantTransfer(): MerchantTransfer
    {
        return $this->merchantTransfer;
    }

    public function getProductConcreteTransfer(): ProductConcreteTransfer
    {
        return $this->productConcreteTransfer;
    }

    public function getProductConcreteTransferWithMerchantProductOffer(): ProductConcreteTransfer
    {
        return $this->productConcreteTransferWithMerchantProductOffer;
    }

    public function getProductOfferTransfer(): ProductOfferTransfer
    {
        return $this->productOfferTransfer;
    }

    public function getOrderWithMerchantProductOffer(): SaveOrderTransfer
    {
        return $this->orderWithMerchantProductOffer;
    }

    public function buildFixtures(CartReorderApiTester $I): FixturesContainerInterface
    {
        $I->configureStateMachine();
        $this->storeTransfer = $I->getCurrentStore();
        $this->customerTransfer = $I->createCustomer(static::TEST_USERNAME);

        $this->merchantTransfer = $this->createMerchant($I);
        $this->productConcreteTransfer = $I->createProductWithPriceAndStock($this->storeTransfer);
        $this->productConcreteTransferWithMerchantProductOffer = $I->createProductWithPriceAndStock($this->storeTransfer);
        $this->productOfferTransfer = $this->createProductOffer($I);

        $this->orderWithMerchantProductOffer = $this->createOrderWithMerchantProductOffer($I);

        return $this;
    }

    protected function createMerchant(CartReorderApiTester $I): MerchantTransfer
    {
        $merchantTransfer = (new MerchantBuilder([
            MerchantTransfer::STATUS => static::MERCHANT_STATUS_APPROVED,
            MerchantTransfer::IS_ACTIVE => true,
            MerchantTransfer::STORE_RELATION => (new StoreRelationTransfer())
                ->addIdStores($this->storeTransfer->getIdStoreOrFail())
                ->addStores($this->storeTransfer),
        ]))->withMerchantProfile()->build();

        $merchantTransfer = $I->haveMerchant($merchantTransfer->toArray(true, true));
        foreach ($merchantTransfer->getStocks() as $stockTransfer) {
            $I->haveStockStoreRelation($stockTransfer, $this->storeTransfer);
        }

        return $merchantTransfer;
    }

    protected function createProductOffer(CartReorderApiTester $I): ProductOfferTransfer
    {
        $productOfferTransfer = $I->haveProductOffer([
            ProductOfferTransfer::ID_PRODUCT_CONCRETE => $this->productConcreteTransferWithMerchantProductOffer->getIdProductConcreteOrFail(),
            ProductOfferTransfer::CONCRETE_SKU => $this->productConcreteTransferWithMerchantProductOffer->getSkuOrFail(),
            ProductOfferTransfer::MERCHANT_REFERENCE => $this->merchantTransfer->getMerchantReferenceOrFail(),
            ProductOfferTransfer::STORES => new ArrayObject([$this->storeTransfer]),
        ]);

        $merchantStocksData = array_map(function (StockTransfer $stockTransfer) {
            return $stockTransfer->toArray();
        }, $this->merchantTransfer->getStocks()->getArrayCopy());

        $I->haveProductOfferStock([
            ProductOfferStockTransfer::ID_PRODUCT_OFFER => $productOfferTransfer->getIdProductOfferOrFail(),
            ProductOfferStockTransfer::QUANTITY => 100,
            ProductOfferStockTransfer::IS_NEVER_OUT_OF_STOCK => true,
        ], $merchantStocksData);

        return $productOfferTransfer;
    }

    protected function createOrderWithMerchantProductOffer(CartReorderApiTester $I): SaveOrderTransfer
    {
        $itemsData = [
            (new ItemBuilder([
                ItemTransfer::SKU => $this->productConcreteTransfer->getSkuOrFail(),
                ItemTransfer::QUANTITY => 1,
            ]))->build()->toArray(),
            (new ItemBuilder([
                ItemTransfer::SKU => $this->productConcreteTransferWithMerchantProductOffer->getSkuOrFail(),
                ItemTransfer::QUANTITY => 2,
                ItemTransfer::PRODUCT_OFFER_REFERENCE => $this->productOfferTransfer->getProductOfferReferenceOrFail(),
                ItemTransfer::MERCHANT_REFERENCE => $this->merchantTransfer->getMerchantReferenceOrFail(),
            ]))->build()->toArray(),
        ];

        return $I->createOrder($this->customerTransfer, [QuoteTransfer::ITEMS => $itemsData]);
    }
}
