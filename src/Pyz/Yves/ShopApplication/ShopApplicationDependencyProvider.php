<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Yves\ShopApplication;

use Pyz\Yves\ProductRelationWidget\Widget\UpSellingProductsWidget;
use Pyz\Yves\ProductReviewWidget\Widget\ProductDetailPageReviewWidget;
use Pyz\Yves\ProductSetWidget\Widget\ProductSetIdsWidget;
use Spryker\Yves\CustomerDataChangeRequest\Widget\CustomerEmailChangeRequestWidget;
use Spryker\Yves\ErrorHandler\Plugin\Application\ErrorHandlerApplicationPlugin;
use Spryker\Yves\EventDispatcher\Plugin\Application\EventDispatcherApplicationPlugin;
use Spryker\Yves\Form\Plugin\Application\FormApplicationPlugin;
use Spryker\Yves\Http\Plugin\Application\YvesHttpApplicationPlugin;
use Spryker\Yves\Locale\Plugin\Application\LocaleApplicationPlugin;
use Spryker\Yves\Messenger\Plugin\Application\FlashMessengerApplicationPlugin;
use Spryker\Yves\MultiFactorAuth\Widget\MultiFactorAuthHandlerWidget;
use Spryker\Yves\MultiFactorAuth\Widget\SetMultiFactorAuthMenuItemWidget;
use Spryker\Yves\Router\Plugin\Application\RouterApplicationPlugin;
use Spryker\Yves\Security\Plugin\Application\YvesSecurityApplicationPlugin;
use Spryker\Yves\Session\Plugin\Application\SessionApplicationPlugin;
use Spryker\Yves\Sitemap\Widget\SitemapWidget;
use Spryker\Yves\Translator\Plugin\Application\TranslatorApplicationPlugin;
use Spryker\Yves\Twig\Plugin\Application\TwigApplicationPlugin;
use Spryker\Yves\Validator\Plugin\Application\ValidatorApplicationPlugin;
use SprykerShop\Yves\AgentWidget\Widget\AgentControlBarWidget;
use SprykerShop\Yves\AssetWidget\Widget\AssetWidget;
use SprykerShop\Yves\AvailabilityNotificationWidget\Widget\AvailabilityNotificationSubscriptionWidget;
use SprykerShop\Yves\BarcodeWidget\Widget\BarcodeWidget;
use SprykerShop\Yves\CartCodeWidget\Widget\CartCodeFormWidget;
use SprykerShop\Yves\CartNoteWidget\Plugin\ShopApplication\CartItemNoteFormWidgetCacheKeyGeneratorStrategyPlugin;
use SprykerShop\Yves\CartNoteWidget\Widget\CartItemNoteFormWidget;
use SprykerShop\Yves\CartNoteWidget\Widget\CartNoteFormWidget;
use SprykerShop\Yves\CartPage\Widget\AddItemsFormWidget;
use SprykerShop\Yves\CartPage\Widget\AddToCartFormWidget;
use SprykerShop\Yves\CartPage\Widget\CartAddProductAsSeparateItemWidget;
use SprykerShop\Yves\CartPage\Widget\CartChangeQuantityFormWidget;
use SprykerShop\Yves\CartPage\Widget\CartSummaryHideTaxAmountWidget;
use SprykerShop\Yves\CartPage\Widget\ProductAbstractAddToCartButtonWidget;
use SprykerShop\Yves\CartPage\Widget\RemoveFromCartFormWidget;
use SprykerShop\Yves\CartReorderPage\Widget\CartReorderItemCheckboxWidget;
use SprykerShop\Yves\CartReorderPage\Widget\CartReorderItemsWidget;
use SprykerShop\Yves\CartReorderPage\Widget\CartReorderWidget;
use SprykerShop\Yves\CategoryImageStorageWidget\Widget\CategoryImageStorageWidget;
use SprykerShop\Yves\CheckoutWidget\Widget\CheckoutBreadcrumbWidget;
use SprykerShop\Yves\CheckoutWidget\Widget\ProceedToCheckoutButtonWidget;
use SprykerShop\Yves\ClickAndCollectPageExample\Plugin\ShopApplication\ClickAndCollectServicePointAddressFormWidgetCacheKeyGeneratorStrategyPlugin;
use SprykerShop\Yves\ClickAndCollectPageExample\Widget\ClickAndCollectServicePointAddressFormWidget;
use SprykerShop\Yves\ConfigurableBundleNoteWidget\Widget\ConfiguredBundleNoteWidget;
use SprykerShop\Yves\ConfigurableBundleWidget\Widget\QuoteConfiguredBundleWidget;
use SprykerShop\Yves\CurrencyWidget\Widget\CurrencyWidget;
use SprykerShop\Yves\CustomerPage\Plugin\Application\CustomerConfirmationUserCheckerApplicationPlugin;
use SprykerShop\Yves\CustomerPage\Widget\CustomerNavigationWidget;
use SprykerShop\Yves\CustomerValidationPage\Plugin\ShopApplication\LogoutInvalidatedCustomerFilterControllerEventHandlerPlugin;
use SprykerShop\Yves\DiscountPromotionWidget\Plugin\ShopApplication\CartDiscountPromotionProductListWidgetCacheKeyGeneratorStrategyPlugin;
use SprykerShop\Yves\DiscountPromotionWidget\Widget\CartDiscountPromotionProductListWidget;
use SprykerShop\Yves\LanguageSwitcherWidget\Widget\LanguageSwitcherWidget;
use SprykerShop\Yves\MerchantOpeningHoursWidget\Widget\MerchantOpeningHoursWidget;
use SprykerShop\Yves\MerchantProductOfferWidget\Widget\MerchantProductOfferWidget;
use SprykerShop\Yves\MerchantProductWidget\Widget\MerchantProductWidget;
use SprykerShop\Yves\MerchantSalesOrderWidget\Widget\MerchantOrderReferenceForItemsWidget;
use SprykerShop\Yves\MerchantSalesReturnWidget\Plugin\MerchantSalesReturnCreateFormWidgetCacheKeyGeneratorStrategyPlugin;
use SprykerShop\Yves\MerchantSalesReturnWidget\Widget\MerchantSalesReturnCreateFormWidget;
use SprykerShop\Yves\MerchantWidget\Widget\SoldByMerchantWidget;
use SprykerShop\Yves\MoneyWidget\Widget\CurrencyIsoCodeWidget;
use SprykerShop\Yves\NewsletterWidget\Widget\NewsletterSubscriptionSummaryWidget;
use SprykerShop\Yves\NewsletterWidget\Widget\NewsletterSubscriptionWidget;
use SprykerShop\Yves\OrderCancelWidget\Widget\OrderCancelButtonWidget;
use SprykerShop\Yves\OrderCustomReferenceWidget\Widget\OrderCustomReferenceWidget;
use SprykerShop\Yves\PaymentAppWidget\Widget\ExpressCheckoutPaymentWidget;
use SprykerShop\Yves\PriceProductVolumeWidget\Widget\CurrentProductPriceVolumeWidget;
use SprykerShop\Yves\PriceProductWidget\Widget\PriceProductWidget;
use SprykerShop\Yves\PriceWidget\Widget\PriceModeSwitcherWidget;
use SprykerShop\Yves\ProductAlternativeWidget\Widget\ProductAlternativeListWidget;
use SprykerShop\Yves\ProductAlternativeWidget\Widget\ShoppingListProductAlternativeWidget;
use SprykerShop\Yves\ProductAlternativeWidget\Widget\WishlistProductAlternativeWidget;
use SprykerShop\Yves\ProductBarcodeWidget\Widget\ProductBarcodeWidget;
use SprykerShop\Yves\ProductBundleWidget\Widget\ProductBundleCartItemsListWidget;
use SprykerShop\Yves\ProductBundleWidget\Widget\ProductBundleItemCounterWidget;
use SprykerShop\Yves\ProductBundleWidget\Widget\ProductBundleItemsMultiCartItemsListWidget;
use SprykerShop\Yves\ProductBundleWidget\Widget\ProductBundleMultiCartItemsListWidget;
use SprykerShop\Yves\ProductBundleWidget\Widget\ProductBundleProductDetailPageItemsListWidget;
use SprykerShop\Yves\ProductCategoryWidget\Widget\ProductBreadcrumbsWithCategoriesWidget;
use SprykerShop\Yves\ProductCategoryWidget\Widget\ProductSchemaOrgCategoryWidget;
use SprykerShop\Yves\ProductConfigurationCartWidget\Widget\ProductConfigurationCartItemDisplayWidget;
use SprykerShop\Yves\ProductConfigurationCartWidget\Widget\ProductConfigurationCartPageButtonWidget;
use SprykerShop\Yves\ProductConfigurationCartWidget\Widget\ProductConfigurationQuoteValidatorWidget;
use SprykerShop\Yves\ProductConfigurationWidget\Widget\ProductConfigurationProductDetailPageButtonWidget;
use SprykerShop\Yves\ProductConfigurationWidget\Widget\ProductConfigurationProductViewDisplayWidget;
use SprykerShop\Yves\ProductConfigurationWishlistWidget\Widget\ProductConfigurationWishlistFormWidget;
use SprykerShop\Yves\ProductConfigurationWishlistWidget\Widget\ProductConfigurationWishlistItemDisplayWidget;
use SprykerShop\Yves\ProductConfigurationWishlistWidget\Widget\ProductConfigurationWishlistPageButtonWidget;
use SprykerShop\Yves\ProductDiscontinuedWidget\Widget\ProductDiscontinuedNoteWidget;
use SprykerShop\Yves\ProductDiscontinuedWidget\Widget\ProductDiscontinuedWidget;
use SprykerShop\Yves\ProductGroupWidget\Widget\ProductGroupColorWidget;
use SprykerShop\Yves\ProductGroupWidget\Widget\ProductGroupWidget;
use SprykerShop\Yves\ProductLabelWidget\Widget\ProductAbstractLabelWidget;
use SprykerShop\Yves\ProductLabelWidget\Widget\ProductConcreteLabelWidget;
use SprykerShop\Yves\ProductOfferServicePointAvailabilityWidget\Widget\ProductOfferServicePointAvailabilityDisplayWidget;
use SprykerShop\Yves\ProductOfferServicePointAvailabilityWidget\Widget\ProductOfferServicePointAvailabilityWidget;
use SprykerShop\Yves\ProductOptionWidget\Widget\ProductOptionConfiguratorWidget;
use SprykerShop\Yves\ProductRelationWidget\Widget\SimilarProductsWidget;
use SprykerShop\Yves\ProductReplacementForWidget\Widget\ProductReplacementForListWidget;
use SprykerShop\Yves\ProductReviewWidget\Widget\DisplayProductAbstractReviewWidget;
use SprykerShop\Yves\ProductReviewWidget\Widget\ProductRatingFilterWidget;
use SprykerShop\Yves\ProductReviewWidget\Widget\ProductReviewDisplayWidget;
use SprykerShop\Yves\ProductSearchWidget\Widget\ProductConcreteAddWidget;
use SprykerShop\Yves\ProductSearchWidget\Widget\ProductConcreteSearchGridWidget;
use SprykerShop\Yves\ProductSearchWidget\Widget\ProductConcreteSearchWidget;
use SprykerShop\Yves\ProductWidget\Widget\CatalogPageProductWidget;
use SprykerShop\Yves\ProductWidget\Widget\CmsProductGroupWidget;
use SprykerShop\Yves\ProductWidget\Widget\CmsProductWidget;
use SprykerShop\Yves\ProductWidget\Widget\PdpProductRelationWidget;
use SprykerShop\Yves\ProductWidget\Widget\PdpProductReplacementForListWidget;
use SprykerShop\Yves\ProductWidget\Widget\ProductAlternativeWidget;
use SprykerShop\Yves\SalesConfigurableBundleWidget\Widget\OrderItemsConfiguredBundleWidget;
use SprykerShop\Yves\SalesOrderAmendmentWidget\Widget\CancelOrderAmendmentWidget;
use SprykerShop\Yves\SalesOrderAmendmentWidget\Widget\OrderAmendmentItemLinkWidget;
use SprykerShop\Yves\SalesOrderAmendmentWidget\Widget\OrderAmendmentWidget;
use SprykerShop\Yves\SalesOrderAmendmentWidget\Widget\UpdateOrderCheckoutSubmitButtonTextWidget;
use SprykerShop\Yves\SalesOrderAmendmentWidget\Widget\UpdateOrderCheckoutSuccessTitleWidget;
use SprykerShop\Yves\SalesOrderThresholdWidget\Widget\SalesOrderThresholdWidget;
use SprykerShop\Yves\SalesProductBundleWidget\Widget\OrderItemsProductBundleWidget;
use SprykerShop\Yves\SalesProductConfigurationWidget\Widget\ProductConfigurationOrderItemDisplayWidget;
use SprykerShop\Yves\SalesServicePointWidget\Widget\SalesServicePointNameForShipmentGroupWidget;
use SprykerShop\Yves\ServicePointWidget\Widget\ServicePointNameForShipmentGroupWidget;
use SprykerShop\Yves\ServicePointWidget\Widget\ServicePointSearchWidget;
use SprykerShop\Yves\ShipmentTypeWidget\Plugin\ShopApplication\ShipmentTypeAddressFormWidgetCacheKeyGeneratorStrategyPlugin;
use SprykerShop\Yves\ShipmentTypeWidget\Widget\ShipmentTypeAddressFormWidget;
use SprykerShop\Yves\ShopApplication\Plugin\Application\ShopApplicationApplicationPlugin;
use SprykerShop\Yves\ShopApplication\ShopApplicationDependencyProvider as SprykerShopApplicationDependencyProvider;
use SprykerShop\Yves\StoreWidget\Plugin\ShopApplication\StoreApplicationPlugin;
use SprykerShop\Yves\StoreWidget\Widget\StoreSwitcherWidget;
use SprykerShop\Yves\TabsWidget\Widget\FullTextSearchTabsWidget;
use SprykerShop\Yves\TraceableEventWidget\Widget\TraceableEventWidget;
use SprykerShop\Yves\WebProfilerWidget\Plugin\Application\WebProfilerApplicationPlugin;
use SprykerShop\Yves\WishlistWidget\Widget\WishlistMenuItemWidget;

/**
 * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
 */
class ShopApplicationDependencyProvider extends SprykerShopApplicationDependencyProvider
{
    /**
     * @phpstan-return array<class-string<\Spryker\Yves\Kernel\Widget\AbstractWidget>>
     *
     * @return array<string>
     */
    protected function getGlobalWidgets(): array
    {
        return [
            AgentControlBarWidget::class,
            CartDiscountPromotionProductListWidget::class,
            CartCodeFormWidget::class,
            CartItemNoteFormWidget::class,
            CartNoteFormWidget::class,
            CatalogPageProductWidget::class,
            CheckoutBreadcrumbWidget::class,
            CmsProductGroupWidget::class,
            CmsProductWidget::class,
            CurrencyWidget::class,
            CurrencyIsoCodeWidget::class,
            CustomerNavigationWidget::class,
            DisplayProductAbstractReviewWidget::class,
            ProductGroupColorWidget::class,
            LanguageSwitcherWidget::class,
            NewsletterSubscriptionWidget::class,
            NewsletterSubscriptionSummaryWidget::class,
            PdpProductRelationWidget::class,
            PdpProductReplacementForListWidget::class,
            ProductReplacementForListWidget::class,
            PriceModeSwitcherWidget::class,
            ProductAbstractLabelWidget::class,
            ProductAlternativeListWidget::class,
            ProductAlternativeWidget::class,
            ProductBarcodeWidget::class,
            ProductBreadcrumbsWithCategoriesWidget::class,
            ProductBundleCartItemsListWidget::class,
            ProductBundleItemCounterWidget::class,
            ProductBundleItemsMultiCartItemsListWidget::class,
            ProductBundleMultiCartItemsListWidget::class,
            ProductConcreteLabelWidget::class,
            ProductDetailPageReviewWidget::class,
            ProductDiscontinuedNoteWidget::class,
            ProductDiscontinuedWidget::class,
            ProductGroupWidget::class,
            ProductOptionConfiguratorWidget::class,
            CurrentProductPriceVolumeWidget::class,
            ProductRatingFilterWidget::class,
            ProductReviewDisplayWidget::class,
            ProductSchemaOrgCategoryWidget::class,
            SalesOrderThresholdWidget::class,
            ShoppingListProductAlternativeWidget::class,
            SimilarProductsWidget::class,
            UpSellingProductsWidget::class,
            WishlistMenuItemWidget::class,
            WishlistProductAlternativeWidget::class,
            FullTextSearchTabsWidget::class,
            ProceedToCheckoutButtonWidget::class,
            ProductConcreteSearchWidget::class,
            ProductConcreteSearchGridWidget::class,
            ProductSetIdsWidget::class,
            PriceProductWidget::class,
            CategoryImageStorageWidget::class,
            AvailabilityNotificationSubscriptionWidget::class,
            ProductConcreteAddWidget::class,
            QuoteConfiguredBundleWidget::class,
            ConfiguredBundleNoteWidget::class,
            OrderCustomReferenceWidget::class,
            OrderItemsConfiguredBundleWidget::class,
            BarcodeWidget::class,
            AddToCartFormWidget::class,
            AddItemsFormWidget::class,
            CartChangeQuantityFormWidget::class,
            OrderItemsProductBundleWidget::class,
            RemoveFromCartFormWidget::class,
            ProductAbstractAddToCartButtonWidget::class,
            OrderCancelButtonWidget::class,
            CartAddProductAsSeparateItemWidget::class,
            MerchantProductOfferWidget::class,
            SoldByMerchantWidget::class,
            CurrentProductPriceVolumeWidget::class,
            MerchantProductWidget::class,
            MerchantOpeningHoursWidget::class,
            MerchantSalesReturnCreateFormWidget::class,
            MerchantOrderReferenceForItemsWidget::class,
            AssetWidget::class,
            ProductBundleProductDetailPageItemsListWidget::class,
            ProductConfigurationCartPageButtonWidget::class,
            ProductConfigurationCartItemDisplayWidget::class,
            ProductConfigurationProductDetailPageButtonWidget::class,
            ProductConfigurationProductViewDisplayWidget::class,
            ProductConfigurationOrderItemDisplayWidget::class,
            ProductConfigurationQuoteValidatorWidget::class,
            ProductConfigurationWishlistFormWidget::class,
            ProductConfigurationWishlistItemDisplayWidget::class,
            ProductConfigurationWishlistPageButtonWidget::class,
            StoreSwitcherWidget::class,
            ServicePointSearchWidget::class,
            ShipmentTypeAddressFormWidget::class,
            SalesServicePointNameForShipmentGroupWidget::class,
            ClickAndCollectServicePointAddressFormWidget::class,
            ProductOfferServicePointAvailabilityWidget::class,
            ProductOfferServicePointAvailabilityDisplayWidget::class,
            CartSummaryHideTaxAmountWidget::class,
            ServicePointNameForShipmentGroupWidget::class,
            TraceableEventWidget::class,
            ExpressCheckoutPaymentWidget::class,
            CustomerEmailChangeRequestWidget::class,
            SetMultiFactorAuthMenuItemWidget::class,
            MultiFactorAuthHandlerWidget::class,
            SitemapWidget::class,
            CartReorderWidget::class,
            CartReorderItemCheckboxWidget::class,
            CartReorderItemsWidget::class,
            OrderAmendmentWidget::class,
            CancelOrderAmendmentWidget::class,
            OrderAmendmentItemLinkWidget::class,
            UpdateOrderCheckoutSubmitButtonTextWidget::class,
            UpdateOrderCheckoutSuccessTitleWidget::class,
        ];
    }

    /**
     * @return array<\SprykerShop\Yves\ShopApplicationExtension\Dependency\Plugin\WidgetCacheKeyGeneratorStrategyPluginInterface>
     */
    protected function getWidgetCacheKeyGeneratorStrategyPlugins(): array
    {
        return [
            new CartDiscountPromotionProductListWidgetCacheKeyGeneratorStrategyPlugin(),
            new CartItemNoteFormWidgetCacheKeyGeneratorStrategyPlugin(),
            new MerchantSalesReturnCreateFormWidgetCacheKeyGeneratorStrategyPlugin(),
            new ShipmentTypeAddressFormWidgetCacheKeyGeneratorStrategyPlugin(),
            new ClickAndCollectServicePointAddressFormWidgetCacheKeyGeneratorStrategyPlugin(),
        ];
    }

    /**
     * @return array<\SprykerShop\Yves\ShopApplicationExtension\Dependency\Plugin\FilterControllerEventHandlerPluginInterface>
     */
    protected function getFilterControllerEventSubscriberPlugins(): array
    {
        return [
            new LogoutInvalidatedCustomerFilterControllerEventHandlerPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Shared\ApplicationExtension\Dependency\Plugin\ApplicationPluginInterface>
     */
    protected function getApplicationPlugins(): array
    {
        $applicationPlugins = [
            new YvesHttpApplicationPlugin(),
            new TwigApplicationPlugin(),
            new EventDispatcherApplicationPlugin(),
            new ShopApplicationApplicationPlugin(),
            new StoreApplicationPlugin(),
            new LocaleApplicationPlugin(),
            new TranslatorApplicationPlugin(),
            new RouterApplicationPlugin(),
            new SessionApplicationPlugin(),
            new ErrorHandlerApplicationPlugin(),
            new FlashMessengerApplicationPlugin(),
            new FormApplicationPlugin(),
            new ValidatorApplicationPlugin(),
            new YvesSecurityApplicationPlugin(),
            new CustomerConfirmationUserCheckerApplicationPlugin(),
        ];

        if (class_exists(WebProfilerApplicationPlugin::class)) {
            $applicationPlugins[] = new WebProfilerApplicationPlugin();
        }

        return $applicationPlugins;
    }
}
