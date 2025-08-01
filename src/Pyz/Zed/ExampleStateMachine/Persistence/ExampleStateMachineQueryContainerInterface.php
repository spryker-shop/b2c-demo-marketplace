<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\ExampleStateMachine\Persistence;

use Orm\Zed\ExampleStateMachine\Persistence\ExampleStateMachineItemQuery;
use Propel\Runtime\Collection\ObjectCollection;

interface ExampleStateMachineQueryContainerInterface
{
    /**
     * @param array<int> $stateIds
     *
     * @return \Orm\Zed\ExampleStateMachine\Persistence\ExampleStateMachineItemQuery
     */
    public function queryStateMachineItemsByStateIds(array $stateIds = []): ExampleStateMachineItemQuery;

    /**
     * @return \Propel\Runtime\Collection\ObjectCollection<\Orm\Zed\ExampleStateMachine\Persistence\ExampleStateMachineItem>
     */
    public function queryAllStateMachineItems(): ObjectCollection;

    /**
     * @param int $idStateMachineItem
     *
     * @return \Orm\Zed\ExampleStateMachine\Persistence\ExampleStateMachineItemQuery|\Propel\Runtime\Collection\ObjectCollection|array<\Orm\Zed\ExampleStateMachine\Persistence\ExampleStateMachineItem>
     */
    public function queryExampleStateMachineItemByIdStateMachineItem(int $idStateMachineItem);
}
