<?php
/**
 * (c) Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Vespolina\InventoryBundle\Model;

/**
 * The inventory statistics interface describes a proxy object describing stock levels
 *
 * Depening
 *
 * @author Daniel Kucharski <daniel@xerias.be>
 */
interface InventoryStatisticsInterface
{


    /**
     * Get the inventory object which this statistic is all about
     *
     * @abstract
     * @return InventoryInterface
     */
    function getInventory();

    /**
     * Retrieve the total count
     *
     * @abstract
     * @return int
     *
     */
    function getTotalCount();

    /**
     * Retrieve a detailed count per storage location for the given inventory set
     *
     * @abstract
     * @granularity Level of granularity (eg. 1 = warehouse level, 2 = storage location level )
     * @return Collection (eg.  [storage_location_A] -> 2, [storage_location_B2 -> 4] )
     */
    function getDetailedCount($granularity);

    /**
     * When was this inventory statistic lastly updated
     * (eg. this could a full day if inventory data comes from an external party )
     *
     * @abstract
     * @return void
     */
    function getUpdatedAt();



}
