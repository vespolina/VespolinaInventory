<?php
/**
 * (c) Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Vespolina\InventoryBundle\Model;

/**
 * @author Daniel Kucharski <daniel@xerias.be>
 * @author Richard Shank <develop@zestic.com>
 */
interface WarehouseInterface
{

    /**
     * Get the address (street, nr, ....) where the warehouse is located
     *
     * @abstract
     * @return AddressInterface
     */
    function getAddress();

    /**
     * Name of this warehouse
     *
     * @abstract
     * @return string
     */
    function getName();

    function setAddress($address);
    
    function setName($name);


}
