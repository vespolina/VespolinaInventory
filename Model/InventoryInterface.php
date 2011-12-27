<?php
/**
 * (c) Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Vespolina\InventoryBundle\Model;

use Vespolina\ProductBundle\Model\Identifier\IdentifierInterface;  //TODO move to CoreBundle

/**
 * @author Daniel Kucharski <daniel@xerias.be>
 * @author Richard Shank <develop@zestic.com>
 */
interface InventoryInterface
{
    /**
     * Retrieve a detailed count per storage location for the given inventory set
     *
     * @abstract
     * @granularity Level of granularity (eg. 1 = warehouse level, 2 = storage location level )
     * @return Collection (eg.  [storage_location_A] -> 2, [storage_location_B2 -> 4] )
     */
    function getDetailedCount($granularity);

    /**
     * An inventory object should at least have an unique ID (eg. SKU)
     *
     * @abstract
     * @return IdentifierInterface
     */
    function getIdentifier();

    /**
     * Retrieve the count
     *
     * @abstract
     * @return int
     *
     */
    function getCount();

    /**
     * When was this inventory statistic lastly updated
     * (eg. this could a full day if inventory data comes from an external party )
     *
     * @abstract
     * @return void
     */
    function getUpdatedAt();

    function setDetailedCount($detailedCount);

    function setIdentifier(IdentifierInterface $identifier);

    /**
     * Add items to the inventory.
     *
     * @param integer $items
     * @param optional $location
     */
    function addToStock($items, $location = null);
}
