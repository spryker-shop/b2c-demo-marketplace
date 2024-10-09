<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Publisher;

use Spryker\Shared\GlossaryStorage\GlossaryStorageConfig;
use Spryker\Shared\PublishAndSynchronizeHealthCheck\PublishAndSynchronizeHealthCheckConfig;
use Spryker\Zed\AssetStorage\Communication\Plugin\Publisher\Asset\AssetDeletePublisherPlugin;
use Spryker\Zed\AssetStorage\Communication\Plugin\Publisher\Asset\AssetWritePublisherPlugin;
use Spryker\Zed\AssetStorage\Communication\Plugin\Publisher\AssetPublisherTriggerPlugin;
use Spryker\Zed\CategoryImageStorage\Communication\Plugin\Publisher\CategoryImagePublisherTriggerPlugin;
use Spryker\Zed\CategoryPageSearch\Communication\Plugin\Publisher\Category\CategoryDeletePublisherPlugin as CategoryPageSearchCategoryDeletePublisherPlugin;
use Spryker\Zed\CategoryPageSearch\Communication\Plugin\Publisher\Category\CategoryWritePublisherPlugin as CategoryPageSearchCategoryWritePublisherPlugin;
use Spryker\Zed\CategoryPageSearch\Communication\Plugin\Publisher\CategoryAttribute\CategoryAttributeDeletePublisherPlugin as CategoryPageSearchCategoryAttributeDeletePublisherPlugin;
use Spryker\Zed\CategoryPageSearch\Communication\Plugin\Publisher\CategoryAttribute\CategoryAttributeWritePublisherPlugin as CategoryPageSearchCategoryAttributeWritePublisherPlugin;
use Spryker\Zed\CategoryPageSearch\Communication\Plugin\Publisher\CategoryNode\CategoryNodeDeletePublisherPlugin as CategoryPageSearchCategoryNodeDeletePublisherPlugin;
use Spryker\Zed\CategoryPageSearch\Communication\Plugin\Publisher\CategoryNode\CategoryNodeWritePublisherPlugin as CategoryPageSearchCategoryNodeWritePublisherPlugin;
use Spryker\Zed\CategoryPageSearch\Communication\Plugin\Publisher\CategoryPagePublisherTriggerPlugin;
use Spryker\Zed\CategoryPageSearch\Communication\Plugin\Publisher\CategoryStore\CategoryStoreWriteForPublishingPublisherPlugin as CategoryStoreSearchWriteForPublishingPublisherPlugin;
use Spryker\Zed\CategoryPageSearch\Communication\Plugin\Publisher\CategoryStore\CategoryStoreWritePublisherPlugin as CategoryStoreSearchWritePublisherPlugin;
use Spryker\Zed\CategoryPageSearch\Communication\Plugin\Publisher\CategoryTemplate\CategoryTemplateDeletePublisherPlugin as CategoryPageSearchCategoryTemplateDeletePublisherPlugin;
use Spryker\Zed\CategoryPageSearch\Communication\Plugin\Publisher\CategoryTemplate\CategoryTemplateWritePublisherPlugin as CategoryPageSearchCategoryTemplateWritePublisherPlugin;
use Spryker\Zed\CategoryStorage\Communication\Plugin\Publisher\Category\CategoryDeletePublisherPlugin;
use Spryker\Zed\CategoryStorage\Communication\Plugin\Publisher\Category\CategoryWritePublisherPlugin as CategoryStoreCategoryWritePublisherPlugin;
use Spryker\Zed\CategoryStorage\Communication\Plugin\Publisher\CategoryAttribute\CategoryAttributeDeletePublisherPlugin;
use Spryker\Zed\CategoryStorage\Communication\Plugin\Publisher\CategoryAttribute\CategoryAttributeWritePublisherPlugin;
use Spryker\Zed\CategoryStorage\Communication\Plugin\Publisher\CategoryNode\CategoryNodeDeletePublisherPlugin;
use Spryker\Zed\CategoryStorage\Communication\Plugin\Publisher\CategoryNode\CategoryNodeWritePublisherPlugin;
use Spryker\Zed\CategoryStorage\Communication\Plugin\Publisher\CategoryNodePublisherTriggerPlugin;
use Spryker\Zed\CategoryStorage\Communication\Plugin\Publisher\CategoryStore\CategoryStoreWriteForPublishingPublisherPlugin as CategoryStoreStorageWriteForPublishingPublisherPlugin;
use Spryker\Zed\CategoryStorage\Communication\Plugin\Publisher\CategoryStore\CategoryStoreWritePublisherPlugin as CategoryStoreStorageWritePublisherPlugin;
use Spryker\Zed\CategoryStorage\Communication\Plugin\Publisher\CategoryTemplate\CategoryTemplateDeletePublisherPlugin;
use Spryker\Zed\CategoryStorage\Communication\Plugin\Publisher\CategoryTemplate\CategoryTemplateWritePublisherPlugin;
use Spryker\Zed\CategoryStorage\Communication\Plugin\Publisher\CategoryTree\CategoryTreeDeletePublisherPlugin;
use Spryker\Zed\CategoryStorage\Communication\Plugin\Publisher\CategoryTree\CategoryTreeWriteForPublishingPublisherPlugin;
use Spryker\Zed\CategoryStorage\Communication\Plugin\Publisher\CategoryTreePublisherTriggerPlugin;
use Spryker\Zed\CategoryStorage\Communication\Plugin\Publisher\ParentWritePublisherPlugin;
use Spryker\Zed\CustomerAccessStorage\Communication\Plugin\Publisher\CustomerAccessPublisherTriggerPlugin;
use Spryker\Zed\CustomerStorage\Communication\Plugin\Publisher\Customer\CustomerInvalidatedWritePublisherPlugin;
use Spryker\Zed\FileManagerStorage\Communication\Plugin\Publisher\FileManagerPublisherTriggerPlugin;
use Spryker\Zed\GlossaryStorage\Communication\Plugin\Publisher\GlossaryKey\GlossaryDeletePublisherPlugin as GlossaryKeyDeletePublisherPlugin;
use Spryker\Zed\GlossaryStorage\Communication\Plugin\Publisher\GlossaryKey\GlossaryWritePublisherPlugin as GlossaryKeyWriterPublisherPlugin;
use Spryker\Zed\GlossaryStorage\Communication\Plugin\Publisher\GlossaryPublisherTriggerPlugin;
use Spryker\Zed\GlossaryStorage\Communication\Plugin\Publisher\GlossaryTranslation\GlossaryWritePublisherPlugin as GlossaryTranslationWritePublisherPlugin;
use Spryker\Zed\MerchantCategory\Communication\Plugin\Publisher\Category\CategoryWritePublisherPlugin;
use Spryker\Zed\MerchantOpeningHoursStorage\Communication\Plugin\Publisher\MerchantOpeningHours\MerchantOpeningHoursWritePublisherPlugin;
use Spryker\Zed\MerchantProductOfferSearch\Communication\Plugin\Publisher\MerchantProductOfferSearchPublisherTriggerPlugin;
use Spryker\Zed\MerchantProductOfferStorage\Communication\Plugin\Publisher\Merchant\MerchantProductOfferWritePublisherPlugin;
use Spryker\Zed\MerchantProductOfferStorage\Communication\Plugin\Publisher\ProductConcreteProductOffer\MerchantProductConcreteProductOfferWritePublisherPlugin;
use Spryker\Zed\MerchantProductOptionStorage\Communication\Plugin\Publisher\MerchantProductOption\MerchantProductOptionGroupWritePublisherPlugin;
use Spryker\Zed\MerchantProductOptionStorage\Communication\Plugin\Publisher\MerchantProductOptionGroupPublisherTriggerPlugin;
use Spryker\Zed\MerchantProductSearch\Communication\Plugin\Publisher\Merchant\MerchantProductSearchWritePublisherPlugin as MerchantMerchantProductSearchWritePublisherPlugin;
use Spryker\Zed\MerchantProductSearch\Communication\Plugin\Publisher\MerchantProduct\MerchantProductSearchWritePublisherPlugin;
use Spryker\Zed\MerchantProductSearch\Communication\Plugin\Publisher\MerchantProductSearchPublisherTriggerPlugin;
use Spryker\Zed\MerchantProductStorage\Communication\Plugin\Publisher\Merchant\MerchantUpdatePublisherPlugin;
use Spryker\Zed\MerchantProductStorage\Communication\Plugin\Publisher\MerchantProduct\MerchantProductWritePublisherPlugin;
use Spryker\Zed\MerchantProductStorage\Communication\Plugin\Publisher\MerchantProductPublisherTriggerPlugin;
use Spryker\Zed\MerchantSearch\Communication\Plugin\Publisher\Merchant\MerchantDeletePublisherPlugin;
use Spryker\Zed\MerchantSearch\Communication\Plugin\Publisher\Merchant\MerchantWritePublisherPlugin;
use Spryker\Zed\MerchantSearch\Communication\Plugin\Publisher\MerchantCategory\MerchantCategoryWritePublisherPlugin;
use Spryker\Zed\MerchantStorage\Communication\Plugin\Publisher\Merchant\MerchantStoragePublisherPlugin;
use Spryker\Zed\MerchantStorage\Communication\Plugin\Publisher\MerchantPublisherTriggerPlugin;
use Spryker\Zed\PriceProductOfferStorage\Communication\Plugin\Publisher\PriceProductOffer\PriceProductStoreWritePublisherPlugin;
use Spryker\Zed\PriceProductOfferStorage\Communication\Plugin\Publisher\PriceProductOfferPublisherTriggerPlugin;
use Spryker\Zed\Product\Communication\Plugin\Publisher\ProductAbstractUpdatedMessageBrokerPublisherPlugin;
use Spryker\Zed\Product\Communication\Plugin\Publisher\ProductConcreteCreatedMessageBrokerPublisherPlugin;
use Spryker\Zed\Product\Communication\Plugin\Publisher\ProductConcreteDeletedMessageBrokerPublisherPlugin;
use Spryker\Zed\Product\Communication\Plugin\Publisher\ProductConcreteExportedMessageBrokerPublisherPlugin;
use Spryker\Zed\Product\Communication\Plugin\Publisher\ProductConcreteUpdatedMessageBrokerPublisherPlugin;
use Spryker\Zed\ProductAlternativeStorage\Communication\Plugin\Publisher\ProductAlternativePublisherTriggerPlugin;
use Spryker\Zed\ProductBundleStorage\Communication\Plugin\Publisher\ProductBundle\ProductBundlePublishWritePublisherPlugin;
use Spryker\Zed\ProductBundleStorage\Communication\Plugin\Publisher\ProductBundle\ProductBundleWritePublisherPlugin;
use Spryker\Zed\ProductBundleStorage\Communication\Plugin\Publisher\ProductBundlePublisherTriggerPlugin;
use Spryker\Zed\ProductBundleStorage\Communication\Plugin\Publisher\ProductConcrete\ProductBundleWritePublisherPlugin as ProductConcreteProductBundleWritePublisherPlugin;
use Spryker\Zed\ProductCategory\Communication\Plugin\Publisher\ProductCategoryProductUpdatedEventTriggerPlugin;
use Spryker\Zed\ProductCategoryStorage\Communication\Plugin\Publisher\Category\CategoryIsActiveAndCategoryKeyWritePublisherPlugin;
use Spryker\Zed\ProductCategoryStorage\Communication\Plugin\Publisher\Category\CategoryStoreDeletePublisherPlugin;
use Spryker\Zed\ProductCategoryStorage\Communication\Plugin\Publisher\Category\CategoryStoreWriteForPublishingPublisherPlugin;
use Spryker\Zed\ProductCategoryStorage\Communication\Plugin\Publisher\Category\CategoryStoreWritePublisherPlugin;
use Spryker\Zed\ProductCategoryStorage\Communication\Plugin\Publisher\Category\CategoryWritePublisherPlugin as ProductCategoryStorageCategoryWritePublisherPlugin;
use Spryker\Zed\ProductCategoryStorage\Communication\Plugin\Publisher\CategoryAttribute\CategoryAttributeNameWritePublisherPlugin;
use Spryker\Zed\ProductCategoryStorage\Communication\Plugin\Publisher\CategoryAttribute\CategoryAttributeWritePublisherPlugin as ProductCategoryAttributeWritePublisherPlugin;
use Spryker\Zed\ProductCategoryStorage\Communication\Plugin\Publisher\CategoryNode\CategoryNodeWritePublisherPlugin as ProductCategoryNodeWritePublisherPlugin;
use Spryker\Zed\ProductCategoryStorage\Communication\Plugin\Publisher\CategoryUrl\CategoryUrlAndResourceCategorynodeWritePublisherPlugin;
use Spryker\Zed\ProductCategoryStorage\Communication\Plugin\Publisher\CategoryUrl\CategoryUrlWritePublisherPlugin;
use Spryker\Zed\ProductCategoryStorage\Communication\Plugin\Publisher\ProductCategory\ProductCategoryWriteForPublishingPublisherPlugin;
use Spryker\Zed\ProductCategoryStorage\Communication\Plugin\Publisher\ProductCategory\ProductCategoryWritePublisherPlugin;
use Spryker\Zed\ProductCategoryStorage\Communication\Plugin\Publisher\ProductCategoryPublisherTriggerPlugin;
use Spryker\Zed\ProductConfigurationStorage\Communication\Plugin\Publisher\ProductConfiguration\ProductConfigurationDeletePublisherPlugin;
use Spryker\Zed\ProductConfigurationStorage\Communication\Plugin\Publisher\ProductConfiguration\ProductConfigurationWritePublisherPlugin;
use Spryker\Zed\ProductConfigurationStorage\Communication\Plugin\Publisher\ProductConfigurationPublisherTriggerPlugin;
use Spryker\Zed\ProductDiscontinuedStorage\Communication\Plugin\Publisher\ProductDiscontinuedPublisherTriggerPlugin;
use Spryker\Zed\ProductLabel\Communication\Plugin\Publisher\ProductLabelProductUpdatedEventTriggerPlugin;
use Spryker\Zed\ProductLabelSearch\Communication\Plugin\Publisher\ProductLabel\ProductLabelWritePublisherPlugin as ProductLabelSearchWritePublisherPlugin;
use Spryker\Zed\ProductLabelSearch\Communication\Plugin\Publisher\ProductLabelProductAbstract\ProductLabelProductAbstractWritePublisherPlugin as ProductLabelProductAbstractSearchWritePublisherPlugin;
use Spryker\Zed\ProductLabelSearch\Communication\Plugin\Publisher\ProductLabelSearchPublisherTriggerPlugin;
use Spryker\Zed\ProductLabelSearch\Communication\Plugin\Publisher\ProductLabelStore\ProductLabelStoreWritePublisherPlugin as ProductLabelStoreSearchWritePublisherPlugin;
use Spryker\Zed\ProductLabelStorage\Communication\Plugin\Publisher\ProductAbstractLabel\ProductAbstractLabelWritePublisherPlugin as ProductAbstractLabelStorageWritePublisherPlugin;
use Spryker\Zed\ProductLabelStorage\Communication\Plugin\Publisher\ProductAbstractLabelPublisherTriggerPlugin;
use Spryker\Zed\ProductLabelStorage\Communication\Plugin\Publisher\ProductLabelDictionary\ProductLabelDictionaryDeletePublisherPlugin as ProductLabelDictionaryStorageDeletePublisherPlugin;
use Spryker\Zed\ProductLabelStorage\Communication\Plugin\Publisher\ProductLabelDictionary\ProductLabelDictionaryWritePublisherPlugin as ProductLabelDictionaryStorageWritePublisherPlugin;
use Spryker\Zed\ProductLabelStorage\Communication\Plugin\Publisher\ProductLabelDictionaryPublisherTriggerPlugin;
use Spryker\Zed\ProductLabelStorage\Communication\Plugin\Publisher\ProductLabelProductAbstract\ProductLabelProductAbstractWritePublisherPlugin as ProductLabelProductAbstractStorageWritePublisherPlugin;
use Spryker\Zed\ProductListSearch\Communication\Plugin\Publisher\ProductListSearchPublisherTriggerPlugin;
use Spryker\Zed\ProductListStorage\Communication\Plugin\Publisher\ProductListPublisherTriggerPlugin;
use Spryker\Zed\ProductOfferAvailabilityStorage\Communication\Plugin\Publisher\ProductOfferAvailability\ProductOfferAvailabilityProductOfferStoreStoragePublisherPlugin;
use Spryker\Zed\ProductOfferAvailabilityStorage\Communication\Plugin\Publisher\Stock\ProductOfferAvailabilityStockStoragePublisherPlugin;
use Spryker\Zed\ProductOfferAvailabilityStorage\Communication\Plugin\Publisher\StockStore\ProductOfferAvailabilityStockStoreStoragePublisherPlugin;
use Spryker\Zed\ProductOfferServicePointStorage\Communication\Plugin\Publisher\ProductOffer\ProductOfferWritePublisherPlugin as ProductOfferServiceProductOfferWritePublisherPlugin;
use Spryker\Zed\ProductOfferServicePointStorage\Communication\Plugin\Publisher\ProductOfferService\ProductOfferServiceWriteByPublishPublisherPlugin;
use Spryker\Zed\ProductOfferServicePointStorage\Communication\Plugin\Publisher\ProductOfferService\ProductOfferServiceWritePublisherPlugin;
use Spryker\Zed\ProductOfferServicePointStorage\Communication\Plugin\Publisher\ProductOfferServicePublisherTriggerPlugin;
use Spryker\Zed\ProductOfferServicePointStorage\Communication\Plugin\Publisher\ProductOfferStore\ProductOfferStoreWritePublisherPlugin as ProductOfferServiceProductOfferStoreWritePublisherPlugin;
use Spryker\Zed\ProductOfferServicePointStorage\Communication\Plugin\Publisher\Service\ServiceWritePublisherPlugin as ProductOfferServiceServiceWritePublisherPlugin;
use Spryker\Zed\ProductOfferServicePointStorage\Communication\Plugin\Publisher\ServicePoint\ServicePointWritePublisherPlugin as ProductOfferServiceServicePointWritePublisherPlugin;
use Spryker\Zed\ProductOfferServicePointStorage\Communication\Plugin\Publisher\ServicePointStore\ServicePointStoreWritePublisherPlugin as ProductOfferServiceServicePointStoreWritePublisherPlugin;
use Spryker\Zed\ProductOfferShipmentTypeStorage\Communication\Plugin\Publisher\ProductOffer\ProductOfferProductOfferShipmentTypeWritePublisherPlugin;
use Spryker\Zed\ProductOfferShipmentTypeStorage\Communication\Plugin\Publisher\ProductOfferShipmentType\ProductOfferShipmentTypeWritePublisherPlugin;
use Spryker\Zed\ProductOfferShipmentTypeStorage\Communication\Plugin\Publisher\ProductOfferShipmentTypePublisherTriggerPlugin;
use Spryker\Zed\ProductOfferShipmentTypeStorage\Communication\Plugin\Publisher\ProductOfferStore\ProductOfferStoreProductOfferShipmentTypeWritePublisherPlugin;
use Spryker\Zed\ProductOfferShipmentTypeStorage\Communication\Plugin\Publisher\ShipmentType\ShipmentTypeProductOfferShipmentTypeWritePublisherPlugin;
use Spryker\Zed\ProductOfferShipmentTypeStorage\Communication\Plugin\Publisher\ShipmentTypeStore\ShipmentTypeStoreProductOfferShipmentTypeWritePublisherPlugin;
use Spryker\Zed\ProductOfferStorage\Communication\Plugin\Publisher\ProductConcreteOffers\ProductConcreteProductOffersDeletePublisherPlugin;
use Spryker\Zed\ProductOfferStorage\Communication\Plugin\Publisher\ProductConcreteOffers\ProductConcreteProductOffersStoreDeletePublisherPlugin;
use Spryker\Zed\ProductOfferStorage\Communication\Plugin\Publisher\ProductConcreteOffers\ProductConcreteProductOffersStoreWritePublisherPlugin;
use Spryker\Zed\ProductOfferStorage\Communication\Plugin\Publisher\ProductConcreteOffers\ProductConcreteProductOffersWritePublisherPlugin;
use Spryker\Zed\ProductOfferStorage\Communication\Plugin\Publisher\ProductOffer\ProductOfferDeletePublisherPlugin;
use Spryker\Zed\ProductOfferStorage\Communication\Plugin\Publisher\ProductOffer\ProductOfferStoreDeletePublisherPlugin;
use Spryker\Zed\ProductOfferStorage\Communication\Plugin\Publisher\ProductOffer\ProductOfferStoreWritePublisherPlugin;
use Spryker\Zed\ProductOfferStorage\Communication\Plugin\Publisher\ProductOffer\ProductOfferWritePublisherPlugin;
use Spryker\Zed\ProductOfferStorage\Communication\Plugin\Publisher\ProductOfferPublisherTriggerPlugin;
use Spryker\Zed\ProductPageSearch\Communication\Plugin\Publisher\CategoryStore\CategoryStoreProductAbstractPageSearchWritePublisherPlugin;
use Spryker\Zed\ProductPageSearch\Communication\Plugin\Publisher\Product\ProductConcretePageSearchWritePublisherPlugin;
use Spryker\Zed\ProductPageSearch\Communication\Plugin\Publisher\ProductConcretePublisherTriggerPlugin;
use Spryker\Zed\ProductRelationStorage\Communication\Plugin\Publisher\ProductRelation\ProductRelationWriteForPublishingPublisherPlugin;
use Spryker\Zed\ProductRelationStorage\Communication\Plugin\Publisher\ProductRelation\ProductRelationWritePublisherPlugin;
use Spryker\Zed\ProductRelationStorage\Communication\Plugin\Publisher\ProductRelationProductAbstract\ProductRelationProductAbstractWritePublisherPlugin;
use Spryker\Zed\ProductRelationStorage\Communication\Plugin\Publisher\ProductRelationPublisherTriggerPlugin;
use Spryker\Zed\ProductRelationStorage\Communication\Plugin\Publisher\ProductRelationStore\ProductRelationStoreWritePublisherPlugin;
use Spryker\Zed\PublishAndSynchronizeHealthCheckSearch\Communication\Plugin\Publisher\PublishAndSynchronizeHealthCheckSearchPublisherTriggerPlugin;
use Spryker\Zed\PublishAndSynchronizeHealthCheckSearch\Communication\Plugin\Publisher\PublishAndSynchronizeHealthCheckSearchWritePublisherPlugin;
use Spryker\Zed\PublishAndSynchronizeHealthCheckStorage\Communication\Plugin\Publisher\PublishAndSynchronizeHealthCheckPublisherTriggerPlugin;
use Spryker\Zed\PublishAndSynchronizeHealthCheckStorage\Communication\Plugin\Publisher\PublishAndSynchronizeHealthCheckStorageWritePublisherPlugin;
use Spryker\Zed\Publisher\PublisherDependencyProvider as SprykerPublisherDependencyProvider;
use Spryker\Zed\SalesReturnSearch\Communication\Plugin\Publisher\ReturnReason\ReturnReasonDeletePublisherPlugin;
use Spryker\Zed\SalesReturnSearch\Communication\Plugin\Publisher\ReturnReason\ReturnReasonWritePublisherPlugin;
use Spryker\Zed\SalesReturnSearch\Communication\Plugin\Publisher\ReturnReasonPublisherTriggerPlugin;
use Spryker\Zed\ServicePointSearch\Communication\Plugin\Publisher\Service\ServiceWritePublisherPlugin;
use Spryker\Zed\ServicePointSearch\Communication\Plugin\Publisher\ServicePoint\ServicePointDeletePublisherPlugin;
use Spryker\Zed\ServicePointSearch\Communication\Plugin\Publisher\ServicePoint\ServicePointWritePublisherPlugin;
use Spryker\Zed\ServicePointSearch\Communication\Plugin\Publisher\ServicePointAddress\ServicePointAddressWritePublisherPlugin;
use Spryker\Zed\ServicePointSearch\Communication\Plugin\Publisher\ServicePointPublisherTriggerPlugin;
use Spryker\Zed\ServicePointSearch\Communication\Plugin\Publisher\ServicePointStore\ServicePointStoreWritePublisherPlugin;
use Spryker\Zed\ServicePointStorage\Communication\Plugin\Publisher\Service\ServiceWritePublisherPlugin as ServicePointStorageServiceWritePublisherPlugin;
use Spryker\Zed\ServicePointStorage\Communication\Plugin\Publisher\ServicePoint\ServicePointWritePublisherPlugin as ServicePointStorageWritePublisherPlugin;
use Spryker\Zed\ServicePointStorage\Communication\Plugin\Publisher\ServicePointAddress\ServicePointAddressWritePublisherPlugin as ServicePointStorageAddressWritePublisherPlugin;
use Spryker\Zed\ServicePointStorage\Communication\Plugin\Publisher\ServicePointPublisherTriggerPlugin as ServicePointStoragePublisherTriggerPlugin;
use Spryker\Zed\ServicePointStorage\Communication\Plugin\Publisher\ServicePointStore\ServicePointStoreWritePublisherPlugin as ServicePointStorageStoreWritePublisherPlugin;
use Spryker\Zed\ServicePointStorage\Communication\Plugin\Publisher\ServiceType\ServiceTypeWritePublisherPlugin;
use Spryker\Zed\ServicePointStorage\Communication\Plugin\Publisher\ServiceTypePublisherTriggerPlugin;
use Spryker\Zed\ShipmentTypeStorage\Communication\Plugin\Publisher\ShipmentCarrier\ShipmentCarrierShipmentTypeWriterPublisherPlugin;
use Spryker\Zed\ShipmentTypeStorage\Communication\Plugin\Publisher\ShipmentMethod\ShipmentMethodPublishShipmentTypeWriterPublisherPlugin;
use Spryker\Zed\ShipmentTypeStorage\Communication\Plugin\Publisher\ShipmentMethod\ShipmentMethodShipmentTypeWriterPublisherPlugin;
use Spryker\Zed\ShipmentTypeStorage\Communication\Plugin\Publisher\ShipmentMethodStore\ShipmentMethodStoreShipmentTypeWriterPublisherPlugin;
use Spryker\Zed\ShipmentTypeStorage\Communication\Plugin\Publisher\ShipmentType\ShipmentTypeWriterPublisherPlugin;
use Spryker\Zed\ShipmentTypeStorage\Communication\Plugin\Publisher\ShipmentTypePublisherTriggerPlugin;
use Spryker\Zed\ShipmentTypeStorage\Communication\Plugin\Publisher\ShipmentTypeStore\ShipmentTypeStoreWriterPublisherPlugin;
use Spryker\Zed\StoreContextStorage\Communication\Plugin\Publisher\ContextStoreWritePublisherPlugin;
use Spryker\Zed\StoreStorage\Communication\Plugin\Publisher\CountryStore\CountryStoreWritePublisherPlugin;
use Spryker\Zed\StoreStorage\Communication\Plugin\Publisher\CurrencyStore\CurrencyStoreWritePublisherPlugin;
use Spryker\Zed\StoreStorage\Communication\Plugin\Publisher\LocaleStore\LocaleStoreWritePublisherPlugin;
use Spryker\Zed\StoreStorage\Communication\Plugin\Publisher\Store\StoreSynchronizationTriggeringPublisherPlugin;
use Spryker\Zed\StoreStorage\Communication\Plugin\Publisher\Store\StoreWritePublisherPlugin;
use Spryker\Zed\TaxProductStorage\Communication\Plugin\Publisher\TaxProductPublisherTriggerPlugin;
use Spryker\Zed\TaxStorage\Communication\Plugin\Publisher\TaxSetPublisherTriggerPlugin;

class PublisherDependencyProvider extends SprykerPublisherDependencyProvider
{
    /**
     * @return array<\Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface>
     */
    protected function getPublisherPlugins(): array
    {
        return array_merge(
            $this->getPublishAndSynchronizeHealthCheckPlugins(),
            $this->getGlossaryStoragePlugins(),
            $this->getProductRelationStoragePlugins(),
            $this->getProductLabelStoragePlugins(),
            $this->getProductLabelSearchPlugins(),
            $this->getReturnReasonSearchPlugins(),
            $this->getProductBundleStoragePlugins(),
            $this->getCategoryStoragePlugins(),
            $this->getCategoryPageSearchPlugins(),
            $this->getProductPageSearchPlugins(),
            $this->getProductAbstractPageSearchPlugins(),
            $this->getProductCategoryStoragePlugins(),
            $this->getProductBundleStoragePlugins(),
            $this->getMerchantStoragePlugins(),
            $this->getMerchantSearchPlugins(),
            $this->getMerchantProductPlugins(),
            $this->getMerchantOpeningHoursStoragePlugins(),
            $this->getMerchantProductOptionStoragePlugins(),
            $this->getMerchantCategoryPublisherPlugins(),
            $this->getPriceProductOfferStoragePlugins(),
            $this->getMerchantProductSearchPlugins(),
            $this->getProductOfferStoragePlugins(),
            $this->getMerchantProductOfferStoragePlugins(),
            $this->getStoreStoragePlugins(),
            $this->getAssetStoragePlugins(),
            $this->getCustomerStoragePlugins(),
            $this->getProductMessageBrokerPlugins(),
            $this->getProductConfigurationStoragePlugins(),
            $this->getProductOfferAvailabilityStoragePlugins(),
            $this->getServicePointSearchPlugins(),
            $this->getServicePointStoragePlugins(),
            $this->getShipmentTypeStoragePlugins(),
            $this->getProductOfferServicePointStoragePlugins(),
            $this->getProductOfferShipmentTypeStoragePlugins(),
        );
    }

    /**
     * @return array<string, array<int, \Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface>>
     */
    protected function getPublishAndSynchronizeHealthCheckPlugins(): array
    {
        return [
            PublishAndSynchronizeHealthCheckConfig::PUBLISH_PUBLISH_AND_SYNCHRONIZE_HEALTH_CHECK => [
                new PublishAndSynchronizeHealthCheckStorageWritePublisherPlugin(),
                new PublishAndSynchronizeHealthCheckSearchWritePublisherPlugin(),
            ],
        ];
    }

    /**
     * @return array<\Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherTriggerPluginInterface>
     */
    protected function getPublisherTriggerPlugins(): array
    {
        return [
            new GlossaryPublisherTriggerPlugin(),
            new ProductRelationPublisherTriggerPlugin(),
            new ProductAbstractLabelPublisherTriggerPlugin(),
            new ProductLabelDictionaryPublisherTriggerPlugin(),
            new ReturnReasonPublisherTriggerPlugin(),
            new ProductBundlePublisherTriggerPlugin(),
            new CategoryNodePublisherTriggerPlugin(),
            new CategoryTreePublisherTriggerPlugin(),
            new ProductCategoryPublisherTriggerPlugin(),
            new CategoryPagePublisherTriggerPlugin(),
            new MerchantPublisherTriggerPlugin(),
            new ProductConfigurationPublisherTriggerPlugin(),
            new ProductConcretePublisherTriggerPlugin(),
            new ProductAlternativePublisherTriggerPlugin(),
            new ProductDiscontinuedPublisherTriggerPlugin(),
            new TaxSetPublisherTriggerPlugin(),
            new TaxProductPublisherTriggerPlugin(),
            new PublishAndSynchronizeHealthCheckSearchPublisherTriggerPlugin(),
            new PublishAndSynchronizeHealthCheckPublisherTriggerPlugin(),
            new ProductOfferPublisherTriggerPlugin(),
            new ProductListPublisherTriggerPlugin(),
            new ProductListSearchPublisherTriggerPlugin(),
            new ProductLabelSearchPublisherTriggerPlugin(),
            new CategoryImagePublisherTriggerPlugin(),
            new FileManagerPublisherTriggerPlugin(),
            new MerchantProductOfferSearchPublisherTriggerPlugin(),
            new MerchantProductOptionGroupPublisherTriggerPlugin(),
            new MerchantProductSearchPublisherTriggerPlugin(),
            new MerchantProductPublisherTriggerPlugin(),
            new AssetPublisherTriggerPlugin(),
            new PriceProductOfferPublisherTriggerPlugin(),
            new CustomerAccessPublisherTriggerPlugin(),
            new ServicePointPublisherTriggerPlugin(),
            new ServicePointStoragePublisherTriggerPlugin(),
            new ServiceTypePublisherTriggerPlugin(),
            new ShipmentTypePublisherTriggerPlugin(),
            new ProductOfferServicePublisherTriggerPlugin(),
            new ProductOfferShipmentTypePublisherTriggerPlugin(),
        ];
    }

    /**
     * @return array<string, array<int, \Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface>>
     */
    protected function getGlossaryStoragePlugins(): array
    {
        return [
            GlossaryStorageConfig::PUBLISH_TRANSLATION => [
                new GlossaryKeyDeletePublisherPlugin(),
                new GlossaryKeyWriterPublisherPlugin(),
                new GlossaryTranslationWritePublisherPlugin(),
            ],
        ];
    }

    /**
     * @return array<\Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface>
     */
    protected function getMerchantStoragePlugins(): array
    {
        return [
            new MerchantStoragePublisherPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface>
     */
    protected function getMerchantSearchPlugins(): array
    {
        return [
            new MerchantWritePublisherPlugin(),
            new MerchantDeletePublisherPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface>
     */
    protected function getProductRelationStoragePlugins(): array
    {
        return [
            new ProductRelationWritePublisherPlugin(),
            new ProductRelationWriteForPublishingPublisherPlugin(),
            new ProductRelationProductAbstractWritePublisherPlugin(),
            new ProductRelationStoreWritePublisherPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface>
     */
    protected function getProductLabelStoragePlugins(): array
    {
        return [
            new ProductAbstractLabelStorageWritePublisherPlugin(),
            new ProductLabelProductAbstractStorageWritePublisherPlugin(),
            new ProductLabelDictionaryStorageWritePublisherPlugin(),
            new ProductLabelDictionaryStorageDeletePublisherPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface>
     */
    protected function getProductLabelSearchPlugins(): array
    {
        return [
            new ProductLabelSearchWritePublisherPlugin(),
            new ProductLabelProductAbstractSearchWritePublisherPlugin(),
            new ProductLabelStoreSearchWritePublisherPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface>
     */
    protected function getReturnReasonSearchPlugins(): array
    {
        return [
            new ReturnReasonWritePublisherPlugin(),
            new ReturnReasonDeletePublisherPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface>
     */
    protected function getMerchantProductPlugins(): array
    {
        return [
            new MerchantProductWritePublisherPlugin(),
            new MerchantUpdatePublisherPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface>
     */
    protected function getProductBundleStoragePlugins(): array
    {
        return [
            new ProductBundlePublishWritePublisherPlugin(),
            new ProductBundleWritePublisherPlugin(),
            new ProductConcreteProductBundleWritePublisherPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface>
     */
    protected function getCategoryStoragePlugins(): array
    {
        return [
            new CategoryStoreStorageWritePublisherPlugin(),
            new CategoryStoreStorageWriteForPublishingPublisherPlugin(),
            new CategoryTreeWriteForPublishingPublisherPlugin(),
            new CategoryDeletePublisherPlugin(),
            new CategoryStoreCategoryWritePublisherPlugin(),
            new CategoryAttributeDeletePublisherPlugin(),
            new CategoryAttributeWritePublisherPlugin(),
            new CategoryNodeDeletePublisherPlugin(),
            new CategoryNodeWritePublisherPlugin(),
            new CategoryTemplateDeletePublisherPlugin(),
            new CategoryTemplateWritePublisherPlugin(),
            new CategoryTreeDeletePublisherPlugin(),
            new ParentWritePublisherPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface>
     */
    protected function getCategoryPageSearchPlugins(): array
    {
        return [
            new CategoryStoreSearchWritePublisherPlugin(),
            new CategoryStoreSearchWriteForPublishingPublisherPlugin(),
            new CategoryPageSearchCategoryDeletePublisherPlugin(),
            new CategoryPageSearchCategoryWritePublisherPlugin(),
            new CategoryPageSearchCategoryAttributeDeletePublisherPlugin(),
            new CategoryPageSearchCategoryAttributeWritePublisherPlugin(),
            new CategoryPageSearchCategoryNodeDeletePublisherPlugin(),
            new CategoryPageSearchCategoryNodeWritePublisherPlugin(),
            new CategoryPageSearchCategoryTemplateDeletePublisherPlugin(),
            new CategoryPageSearchCategoryTemplateWritePublisherPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface>
     */
    protected function getProductPageSearchPlugins(): array
    {
        return [
            new ProductConcretePageSearchWritePublisherPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface>
     */
    protected function getProductCategoryStoragePlugins(): array
    {
        return [
            new CategoryStoreWritePublisherPlugin(),
            new CategoryStoreWriteForPublishingPublisherPlugin(),
            new CategoryStoreDeletePublisherPlugin(),
            new ProductCategoryStorageCategoryWritePublisherPlugin(),
            new CategoryIsActiveAndCategoryKeyWritePublisherPlugin(),
            new ProductCategoryAttributeWritePublisherPlugin(),
            new CategoryAttributeNameWritePublisherPlugin(),
            new ProductCategoryNodeWritePublisherPlugin(),
            new CategoryUrlWritePublisherPlugin(),
            new CategoryUrlAndResourceCategorynodeWritePublisherPlugin(),
            new ProductCategoryWriteForPublishingPublisherPlugin(),
            new ProductCategoryWritePublisherPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface>
     */
    public function getMerchantOpeningHoursStoragePlugins(): array
    {
        return [
            new MerchantOpeningHoursWritePublisherPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface>
     */
    protected function getMerchantProductOptionStoragePlugins(): array
    {
        return [
            new MerchantProductOptionGroupWritePublisherPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface>
     */
    protected function getMerchantCategoryPublisherPlugins(): array
    {
        return [
            new CategoryWritePublisherPlugin(),
            new MerchantCategoryWritePublisherPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface>
     */
    protected function getPriceProductOfferStoragePlugins(): array
    {
        return [
            new PriceProductStoreWritePublisherPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface>
     */
    protected function getMerchantProductSearchPlugins(): array
    {
        return [
            new MerchantMerchantProductSearchWritePublisherPlugin(),
            new MerchantProductSearchWritePublisherPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface>
     */
    protected function getProductOfferStoragePlugins(): array
    {
        return [
            new ProductConcreteProductOffersDeletePublisherPlugin(),
            new ProductConcreteProductOffersWritePublisherPlugin(),
            new ProductOfferDeletePublisherPlugin(),
            new ProductOfferWritePublisherPlugin(),
            new ProductOfferStoreWritePublisherPlugin(),
            new ProductOfferStoreDeletePublisherPlugin(),
            new ProductConcreteProductOffersStoreWritePublisherPlugin(),
            new ProductConcreteProductOffersStoreDeletePublisherPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface>
     */
    protected function getMerchantProductOfferStoragePlugins(): array
    {
        return [
            new MerchantProductConcreteProductOfferWritePublisherPlugin(),
            new MerchantProductOfferWritePublisherPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface>
     */
    protected function getStoreStoragePlugins(): array
    {
        return [
            new StoreWritePublisherPlugin(),
            new StoreSynchronizationTriggeringPublisherPlugin(),
            new CurrencyStoreWritePublisherPlugin(),
            new CountryStoreWritePublisherPlugin(),
            new LocaleStoreWritePublisherPlugin(),
            new ContextStoreWritePublisherPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface>
     */
    protected function getAssetStoragePlugins(): array
    {
        return [
            new AssetWritePublisherPlugin(),
            new AssetDeletePublisherPlugin(),
        ];
    }

    /**
     * @return array<int, \Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface>
     */
    protected function getCustomerStoragePlugins(): array
    {
        return [
            new CustomerInvalidatedWritePublisherPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface>
     */
    protected function getProductMessageBrokerPlugins(): array
    {
        return [
            new ProductConcreteExportedMessageBrokerPublisherPlugin(),
            new ProductConcreteCreatedMessageBrokerPublisherPlugin(),
            new ProductConcreteUpdatedMessageBrokerPublisherPlugin(),
            new ProductConcreteDeletedMessageBrokerPublisherPlugin(),
            new ProductAbstractUpdatedMessageBrokerPublisherPlugin(),
            new ProductCategoryProductUpdatedEventTriggerPlugin(),
            new ProductLabelProductUpdatedEventTriggerPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface>
     */
    protected function getProductOfferAvailabilityStoragePlugins(): array
    {
        return [
            new ProductOfferAvailabilityProductOfferStoreStoragePublisherPlugin(),
            new ProductOfferAvailabilityStockStoragePublisherPlugin(),
            new ProductOfferAvailabilityStockStoreStoragePublisherPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface>
     */
    protected function getProductConfigurationStoragePlugins(): array
    {
        return [
            new ProductConfigurationWritePublisherPlugin(),
            new ProductConfigurationDeletePublisherPlugin(),
        ];
    }

    /**
     * @return list<\Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface>
     */
    public function getProductAbstractPageSearchPlugins(): array
    {
        return [
            new CategoryStoreProductAbstractPageSearchWritePublisherPlugin(),
        ];
    }

    /**
     * @return list<\Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface>
     */
    protected function getServicePointSearchPlugins(): array
    {
        return [
            new ServicePointWritePublisherPlugin(),
            new ServicePointDeletePublisherPlugin(),
            new ServicePointAddressWritePublisherPlugin(),
            new ServicePointStoreWritePublisherPlugin(),
            new ServiceWritePublisherPlugin(),
        ];
    }

    /**
     * @return list<\Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface>
     */
    protected function getServicePointStoragePlugins(): array
    {
        return [
            new ServicePointStorageWritePublisherPlugin(),
            new ServicePointStorageAddressWritePublisherPlugin(),
            new ServicePointStorageStoreWritePublisherPlugin(),
            new ServicePointStorageServiceWritePublisherPlugin(),
            new ServiceTypeWritePublisherPlugin(),
        ];
    }

    /**
     * @return list<\Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface>
     */
    protected function getShipmentTypeStoragePlugins(): array
    {
        return [
            new ShipmentTypeWriterPublisherPlugin(),
            new ShipmentTypeStoreWriterPublisherPlugin(),
            new ShipmentCarrierShipmentTypeWriterPublisherPlugin(),
            new ShipmentMethodPublishShipmentTypeWriterPublisherPlugin(),
            new ShipmentMethodShipmentTypeWriterPublisherPlugin(),
            new ShipmentMethodStoreShipmentTypeWriterPublisherPlugin(),
        ];
    }

    /**
     * @return list<\Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface>
     */
    protected function getProductOfferServicePointStoragePlugins(): array
    {
        return [
            new ProductOfferServiceWritePublisherPlugin(),
            new ProductOfferServiceWriteByPublishPublisherPlugin(),
            new ProductOfferServiceProductOfferWritePublisherPlugin(),
            new ProductOfferServiceProductOfferStoreWritePublisherPlugin(),
            new ProductOfferServiceServiceWritePublisherPlugin(),
            new ProductOfferServiceServicePointWritePublisherPlugin(),
            new ProductOfferServiceServicePointStoreWritePublisherPlugin(),
        ];
    }

    /**
     * @return list<\Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface>
     */
    protected function getProductOfferShipmentTypeStoragePlugins(): array
    {
        return [
            new ProductOfferShipmentTypeWritePublisherPlugin(),
            new ProductOfferProductOfferShipmentTypeWritePublisherPlugin(),
            new ProductOfferStoreProductOfferShipmentTypeWritePublisherPlugin(),
            new ShipmentTypeProductOfferShipmentTypeWritePublisherPlugin(),
            new ShipmentTypeStoreProductOfferShipmentTypeWritePublisherPlugin(),
        ];
    }
}
