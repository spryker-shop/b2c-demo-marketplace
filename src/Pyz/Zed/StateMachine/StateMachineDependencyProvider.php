<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\StateMachine;

use Pyz\Zed\ExampleStateMachine\Communication\Plugin\TestStateMachineHandlerPlugin;
use Spryker\Zed\MerchantOms\Communication\Plugin\StateMachine\MerchantStateMachineHandlerPlugin;
use Spryker\Zed\StateMachine\StateMachineDependencyProvider as SprykerStateMachineDependencyProvider;

class StateMachineDependencyProvider extends SprykerStateMachineDependencyProvider
{
    /**
     * @return \Spryker\Zed\StateMachine\Dependency\Plugin\StateMachineHandlerInterface[]
     */
    protected function getStateMachineHandlers()
    {
        return [
            new TestStateMachineHandlerPlugin(),
            new MerchantStateMachineHandlerPlugin(),
        ];
    }
}
