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
     * Add items to the inventory.
     *
     * @param Vespolina\InventoryBundle\Model\InventoryInterface $inventory
     * @param integer $items
     * @param optional $location
     */
    function addToStock($inventory, $items, $location = null);

    /**
     * Remove items from the inventory.
     *
     * @param Vespolina\InventoryBundle\Model\InventoryInterface $inventory
     * @param integer $items
     * @param optional $location
     */
    function removeFromStock($inventory, $items, $location = null);

    /**
     * Reserve an number of product items for a specific sale.
     *
     * @param Vespolina\InventoryBundle\Model\InventoryInterface $inventory
     * @param integer the number of items to be reserved, no value defaults to 1
     *
     * @return Vespolina\InventoryBundle\Model\InventoryReservationInterface
     */
    function reserve($inventory, $items = null);

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
     * Update the inventory information based on the supplied InventoryInterface instance
     *
     * @abstract
     * @param InventoryInterface $inventory
     * @return void
     *
     */
/*
    function updateInventory(InventoryInterface $inventory);
*/

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
/*
    function getCountForInventory(IdentifierInterface $identifier,
                                  WarehouseInterface $warehouse = null,
                                  StorageLocationInterface $storageLocation = null);
*/
}
