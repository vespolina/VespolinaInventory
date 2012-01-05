<?php
/**
 * (c) Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Vespolina\InventoryBundle\Document;

use Vespolina\InventoryBundle\Model\InventoryInterface;
use Vespolina\InventoryBundle\Model\InventoryManager as AbstractInventoryManager;
use Vespolina\InventoryBundle\Model\StorageLocationInterface;
use Vespolina\InventoryBundle\Model\WarehouseInterface;

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
    public function createInventory($product, $identifierSet = null)
    {
        $inv = new $this->inventoryClass($product, $identifierSet);
        $this->dm->persist($inv);
        $this->dm->flush();

        return $inv;
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
    public function getCount(InventoryInterface $inventory, WarehouseInterface $warehouse = null, StorageLocationInterface $storageLocation = null)
    {

    }

    /**
     * @inheritdoc
     */
    public function findInventoryForProduct($product, $optionSet = null)
    {
        $qb = $this->dm->CreateQueryBuilder($this->inventoryClass)
            ->find()
            ->field('product')->references($product);
        if ($optionSet) {
            $qb->field('optionSet')->equals($optionSet);
        }
        $results = $qb->getQuery()
            ->execute()
        ;

        if ($results->count() === 1) {
            return $results->getNext();
        }
        return $results;
    }

    protected function lockAndLoad($inventory)
    {
        do {
            $loadedInventory = $this->dm->createQueryBuilder($this->inventoryClass)
                ->findAndUpdate()
                ->field('id')->equals($inventory->getId())
                ->field('inProgress')->equals(false)
                ->field('inProgress')->set(true)
                ->field('processStarted')->set(new \MongoDate())
                ->getQuery()
                ->execute()
            ;
        } while(!$loadedInventory instanceof InventoryInterface);

        return $loadedInventory;
    }

    protected function saveAndUnlock($inventory, $changes)
    {
        $qb = $this->dm->createQueryBuilder($this->inventoryClass)
            ->findAndUpdate()
            ->field('id')->equals($inventory->getId())
            ->field('inProgress')->set(false)
            ->field('processStarted')->unsetField();

        foreach($changes as $field => $value) {
            $qb->field($field)->set($value);
        }

        $qb->getQuery()
            ->execute()
        ;

        // todo: check for failing conditions
        return true;
    }
}
