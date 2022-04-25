<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductStorage\Communication\Plugin\Event\Subscriber;

use Pyz\Zed\ProductBundle\Dependency\ProductBundleEvents;
use Pyz\Zed\ProductStorage\Communication\Plugin\Event\Listener\ProductBundleStoragePublishListener;
use Spryker\Zed\Event\Dependency\EventCollectionInterface;
use Spryker\Zed\ProductStorage\Communication\Plugin\Event\Subscriber\ProductStorageEventSubscriber as SprykerProductStorageEventSubscriber;

class ProductStorageEventSubscriber extends SprykerProductStorageEventSubscriber
{
    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return \Spryker\Zed\Event\Dependency\EventCollectionInterface
     */
    public function getSubscribedEvents(EventCollectionInterface $eventCollection): EventCollectionInterface
    {
        $eventCollection = parent::getSubscribedEvents($eventCollection);
        $eventCollection = $this->addPyzProductBundleCreateStorageListener($eventCollection);
        $eventCollection = $this->addPyzProductBundleUpdateStorageListener($eventCollection);
        $eventCollection = $this->addPyzProductBundleDeleteStorageListener($eventCollection);

        return $eventCollection;
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return \Spryker\Zed\Event\Dependency\EventCollectionInterface
     */
    protected function addPyzProductBundleCreateStorageListener(EventCollectionInterface $eventCollection): EventCollectionInterface
    {
        $eventCollection->addListenerQueued(
            ProductBundleEvents::ENTITY_SPY_PRODUCT_BUNDLE_CREATE,
            new ProductBundleStoragePublishListener()
        );

        return $eventCollection;
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return \Spryker\Zed\Event\Dependency\EventCollectionInterface
     */
    protected function addPyzProductBundleUpdateStorageListener(EventCollectionInterface $eventCollection): EventCollectionInterface
    {
        $eventCollection->addListenerQueued(
            ProductBundleEvents::ENTITY_SPY_PRODUCT_BUNDLE_UPDATE,
            new ProductBundleStoragePublishListener()
        );

        return $eventCollection;
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return \Spryker\Zed\Event\Dependency\EventCollectionInterface
     */
    protected function addPyzProductBundleDeleteStorageListener(EventCollectionInterface $eventCollection): EventCollectionInterface
    {
        $eventCollection->addListenerQueued(
            ProductBundleEvents::ENTITY_SPY_PRODUCT_BUNDLE_DELETE,
            new ProductBundleStoragePublishListener()
        );

        return $eventCollection;
    }
}
