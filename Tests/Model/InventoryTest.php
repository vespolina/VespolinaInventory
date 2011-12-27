<?php
/**
 * (c) Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Vespolina\InventoryBundle\Tests\Model;

use Vespolina\InventoryBundle\Tests\InventoryTestCommon;

/**
 * @author Richard D Shank <develop@zestic.com>
 */
class InventoryTest extends InventoryTestCommon
{
    public function testAddToStock()
    {
        $inventory = $this->createInventory();

        $inventory->addToStock(3);
        $this->assertSame(3, $inventory->getCount());

        $inventory->addToStock(3);
        $this->assertSame(6, $inventory->getCount());

        // todo: set a location for the inventory
    }

    public function testReserve()
    {
        // todo: set a location for the inventory
    }

    public function testReleaseReserved()
    {
        // todo: set a location for the inventory
    }

    public function testRemoveFromStock()
    {
        $inventory = $this->createInventory();
        $inventory->addToStock(6);

        $inventory->removeFromStock(3);
        $this->assertSame(3, $inventory->getCount());

        // todo: set a location for the inventory

        $this->setExpectedException('RangeException');
        $inventory = $this->createInventory();
        $inventory->removeFromStock(6);
    }
}
