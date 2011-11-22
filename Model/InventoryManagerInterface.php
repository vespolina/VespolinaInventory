<?php
/**
 * (c) Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Vespolina\InventoryBundle\Model;

use Vespolina\InventoryBundle\Model\InventoryStatisticInterface;
use Vespolina\InventoryBundle\Model\WarehouseInterface;

/**
 * @author Richard Shank <develop@zestic.com>
 */
interface InventoryManagerInterface
{

    /**
     * Get the inventory statistic object
     *
     * @abstract
     * @param $inventory The inventory instance for which statistic needs to be retrieved
     * @param null|WarehouseInterface $warehouse
     * @param null|StorageLocationInterface $storageLocation
     * @return void
     */
    function getInventoryStatistic(InventoryInterface $inventory,
                                   WarehouseInterface $warehouse = null,
                                   StorageLocationInterface $storageLocation = null);

    /**
     * Compute the statistical values for the provided inventory statistic
     *
     * @abstract
     * @param InventoryStatisticInterface $inventoryStatistic
     * @param null $granularityLevel
     * @return void
     */
    function computeInventoryStatistics(InventoryStatisticsInterface $inventoryStatistic,
                                       $granularityLevel = null);


    /**
     * Return the total count for a given inventory item.
     * Optionally restrict the count to a given warehouse or storage location
     *
     * @abstract
     * @param InventoryInterface $inventory
     * @param null|WarehouseInterface $warehouse
     * @param null|StorageLocationInterface $storageLocation
     * @return void
     */
    function getTotalCountForInventory(InventoryInterface $inventory,
                                       WarehouseInterface $warehouse = null,
                                       StorageLocationInterface $storageLocation = null);

}
