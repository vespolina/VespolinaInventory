<?php
/**
 * (c) Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Vespolina\InventoryBundle\Model;

use Vespolina\InventoryBundle\Model\InventoryInterface;
use Vespolina\InventoryBundle\Model\StorageLocationInterface;
use Vespolina\InventoryBundle\Model\WarehouseInterface;
use Vespolina\ProductBundle\Model\Identifier\IdentifierInterface;  //TODO move to CoreBundle

/**
 * @author Daniel Kucharski <daniel@xerias.be>
 * @author Richard Shank <develop@zestic.com>
 */
interface InventoryManagerInterface
{
    /**
     * @abstract
     * @param $product
     *
     * @return Vespolina\InventoryBundle\Model\InventoryInterface
     */
    function createInventory($product, $identifierSet = null);

    /**
     * Add items to the inventory.
     *
     * @param Vespolina\InventoryBundle\Model\InventoryInterface $inventory
     * @param integer $itemCnt
     * @param optional $location
     */
    function addToInventory(InventoryInterface $inventory, $itemCnt, $location = null);

    /**
     * Remove items from the inventory.
     *
     * @param Vespolina\InventoryBundle\Model\InventoryInterface $inventory
     * @param integer $itemCnt
     * @param optional $location
     */
    function removeFromInventory(InventoryInterface $inventory, $itemCnt, $location = null);

    /**
     * Reserve an number of product items for a specific sale.
     *
     * @param Vespolina\InventoryBundle\Model\InventoryInterface $inventory
     * @param mixed $reservedBy who is reserving the items
     * @param integer the number of items to be reserved, no value defaults to 1
     *
     * @return Vespolina\InventoryBundle\Model\InventoryReservationInterface
     */
    function reserve(InventoryInterface $inventory, $reservedBy, $itemCnt = null);

    /**
     * Release a number of reserved product items
     *
     * @param Vespolina\InventoryBundle\Model\InventoryInterface $inventory
     * @param mixed $reservedBy who is reserving the items
     * @param integer the number of items to be reserved, no value defaults to 1
     *
     * @return Vespolina\InventoryBundle\Model\InventoryInterface
     */
    function releaseReserved(InventoryInterface $inventory, $reservedBy, $itemCnt = null);

    /**
     * Update the inventory information with the inventory size of a single id
     * Optionally individual counts for a specific warehouse or/and storage location can be added
     *
     * @abstract
     * @param $sku
     * @param $updateOperation: (+|-|=)[0-9]
     *        Examples:
     *          +10  : increase stock level with 10
     *          -1   : decrease stock levle with 1
     *          =200 : set stock level to 200
     * @return void
     */
/*
    function updateCount(IdentifierInterface $identifier,
                         $updateOperation,
                         WarehouseInterface $warehouse = null,
                         StorageLocationInterface $storageLocation);
*/
    /**
     * Update the items in the inventory to a set count
     *
     * @param Vespolina\InventoryBundle\Model\InventoryInterface $inventory
     * @param integer $itemCnt
     * @param optional $location

     * @return Vespolina\InventoryBundle\Model\InventoryInterface
     */
    public function setInventoryOnHand(InventoryInterface $inventory, $itemCnt, $location = null);

    /**
     * Return the count for a given inventory id.
     * Optionally restrict the count to a given warehouse or/and storage location
     *
     * @abstract
     * @param InventoryInterface $inventory
     * @param null|WarehouseInterface $warehouse
     * @param null|StorageLocationInterface $storageLocation
     * @return void
     */
    function getCount(InventoryInterface $inventory,
                                  WarehouseInterface $warehouse = null,
                                  StorageLocationInterface $storageLocation = null);

    /**
     * Return all of the available inventory for a specific product / identifierSet
     *
     * @param $product
     * @param null $identifierSet
     *
     * @return array
     */
    function getInventoryForProduct($product, $identifierSet = null);
}
