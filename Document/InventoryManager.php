<?php
/**
 * (c) Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Vespolina\InventoryBundle\Document;

use Vespolina\InventoryBundle\Model\InventoryManager as AbstractInventoryManager;

/**
 * @author Richard Shank <develop@zestic.com>
 */
class InventoryManager extends AbstractInventoryManager
{
    protected $dm;
    protected $inventoryClass;

    public function __construct($documentManager, $inventoryClass)
    {
        $this->dm = $documentManager;
        $this->inventoryClass = $inventoryClass;
    }

    /**
     * @inheritdoc
     */
    public function addToStock($inventory, $items, $location = null)
    {

        if ($location) {
            throw new \Exception('not implemented');
        }

        $inventoryData = $this->dm->createQueryBuilder()
            ->findAndUpdate()
            ->field('_id')->equals(new \MongoId($inventory->getId()))
            ->field('inProgress')->equals(false)
            ->update()
            ->field('inProgress')->set(true)
            ->field('started')->set(new \MongoDate())
            ->getQuery()
            ->execute()
        ;
// todo: need some test here

        $onHand = $inventoryData['onHand'] + $items;
        $available = $inventoryData['available'] + $items;

        $this->dm->createQueryBuilder($this->inventoryClass)
            ->findAndUpdate()
            ->field('_id')->equals(new \MongoId($inventory->getId()))
            ->update()
            ->field('inProgress')->set(false)
            ->field('onHand')->set($onHand)
            ->field('available')->set($available)
            ->getQuery()
            ->execute()
        ;

        // todo: exit on failure
        // todo: remove from unit of work or does unsetting do it?
        $newInventory = clone $inventory;

        unset($inventory);

        $ohp = new \ReflectionProperty($this->inventoryClass, 'onHand');
        $ohp->setAccessible(true);
        $ohp->setValue($newInventory, $onHand);

        $ap = new \ReflectionProperty($this->inventoryClass, 'available');
        $ap->setAccessible(true);
        $ap->setValue($newInventory, $available);

        return $newInventory;
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

    /**
     * @inheritdoc
     */
    public function reserve($inventory, $items = null)
    {
        $items = $items ? $items : 1;

        $this->available -= $items;

    }
}
