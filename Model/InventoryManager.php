<?php
/**
 * (c) Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Vespolina\InventoryBundle\Model;

use Vespolina\InventoryBundle\Model\InventoryManagerInterface;

/**
 * @author Richard Shank <develop@zestic.com>
 */
abstract class InventoryManager implements InventoryManagerInterface
{
    /**
     * @inheritdoc
     */
    public function addToStock($inventory, $items, $location = null)
    {
        if ($location) {
            throw new \Exception('not implemented');
        }

        $this->onHand += (int)$items;
        $this->available += (int)$items;
    }

    /**
     * @inheritdoc
     */
    public function removeFromStock($inventory, $items, $location = null)
    {
        if ($items > $this->onHand) {
            throw new \RangeException(sprintf('There are only %s items in the inventory, so %s items cannot be removed', $this->count, $items));
        }
        $this->onHand -= (int)$items;
        $this->available -= (int)$items;
        if ($location) {
            throw new \Exception('not implemented');
        }
    }
}
