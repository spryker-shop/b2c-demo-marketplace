<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\ShipmentsRestApi;

use Spryker\Glue\CustomersRestApi\Plugin\ShipmentsRestApi\CustomerAddressSourceCheckerPlugin;
use Spryker\Glue\ShipmentsRestApi\ShipmentsRestApiDependencyProvider as SprykerShipmentsRestApiDependencyProvider;
use Spryker\Glue\ShipmentTypeServicePointsRestApi\Plugin\ShipmentsRestApi\MultiShipmentTypeServicePointShippingAddressValidationStrategyPlugin;
use Spryker\Glue\ShipmentTypeServicePointsRestApi\Plugin\ShipmentsRestApi\SingleShipmentTypeServicePointShippingAddressValidationStrategyPlugin;

class ShipmentsRestApiDependencyProvider extends SprykerShipmentsRestApiDependencyProvider
{
    /**
     * @return array<\Spryker\Glue\ShipmentsRestApiExtension\Dependency\Plugin\AddressSourceCheckerPluginInterface>
     */
    protected function getAddressSourceCheckerPlugins(): array
    {
        return [
            new CustomerAddressSourceCheckerPlugin(),
        ];
    }

    /**
     * @return list<\Spryker\Glue\ShipmentsRestApiExtension\Dependency\Plugin\ShippingAddressValidationStrategyPluginInterface>
     */
    protected function getShippingAddressValidationStrategyPlugins(): array
    {
        return [
            new MultiShipmentTypeServicePointShippingAddressValidationStrategyPlugin(),
            new SingleShipmentTypeServicePointShippingAddressValidationStrategyPlugin(),
        ];
    }
}
