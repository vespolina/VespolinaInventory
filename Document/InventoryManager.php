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
    public function createInventory(InventoryInterface $product, $identifierSet = null)
    {
        $inv = new $this->inventoryClass($product, $identifierSet);
        $this->dm->persist($inv);
        $this->dm->flush();

        return $inv;
    }

    /**
     * @inheritdoc
     */
    public function addToInventory(InventoryInterface $inventory, $itemCnt, $location = null)
    {
        if ($location) {
            throw new \Exception('not implemented');
        }

        $loadedInventory = $this->dm->createQueryBuilder($this->inventoryClass)
            ->findAndUpdate()
            ->field('id')->equals($inventory->getId())
            ->field('inProgress')->equals(false)
            ->field('inProgress')->set(true)
            ->field('processStarted')->set(new \MongoDate())
            ->getQuery()
            ->execute()
        ;
// todo: need some test here

        $ohp = new \ReflectionProperty($this->inventoryClass, 'onHand');
        $ohp->setAccessible(true);
        $onHand = $ohp->getValue($loadedInventory) + $itemCnt;
        $ohp->setValue($loadedInventory, $onHand);

        $ap = new \ReflectionProperty($this->inventoryClass, 'available');
        $ap->setAccessible(true);
        $available = $ap->getValue($loadedInventory) + $itemCnt;
        $ap->setValue($loadedInventory, $available);

        $this->dm->createQueryBuilder($this->inventoryClass)
            ->findAndUpdate()
            ->field('id')->equals($inventory->getId())
            ->field('inProgress')->set(false)
            ->field('onHand')->set($loadedInventory->getOnHand())
            ->field('available')->set($loadedInventory->getAvailable())
            ->field('processStarted')->unsetField()
            ->getQuery()
            ->execute()
        ;

        // todo: exit on failure
        // todo: remove from unit of work or does unsetting do it?
        $newInventory = clone $inventory;
        unset($inventory);

//        $ap->setValue($newInventory, $loadedInventory);
//        $ohp->setValue($newInventory, $onHand);

        return $loadedInventory;
    }

    /**
     * @inheritdoc
     */
    public function removeFromInventory(InventoryInterface $inventory, $itemCnt, $location = null)
    {
        if ($itemCnt > $this->onHand) {
            throw new \RangeException(sprintf('There are only %s items in the inventory, so %s items cannot be removed', $this->count, $itemCnt));
        }
        $this->onHand -= (int)$itemCnt;
        $this->available -= (int)$itemCnt;
        if ($location) {
            throw new \Exception('not implemented');
        }
    }

    /**
     * @inheritdoc
     */
    public function reserve(InventoryInterface $inventory, $reservedBy, $itemCnt = null)
    {
        $itemCnt = $itemCnt ? $itemCnt : 1;

        $this->available -= $itemCnt;

    }

    /**
     * @inheritdoc
     */
    public function releaseReserved(InventoryInterface $inventory, $reservedBy, $itemCnt = null)
    {

    }

    /**
     * @inheritdoc
     */
    function getCount(InventoryInterface $inventory, WarehouseInterface $warehouse = null, StorageLocationInterface $storageLocation = null)
    {

    }
}
