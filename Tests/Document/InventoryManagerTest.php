<?php
/**
 * (c) Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Vespolina\InventoryBundle\Tests\Document;

use Vespolina\InventoryBundle\Document\InventoryManager;
use Vespolina\InventoryBundle\Tests\Fixtures\Document\Inventory;

use Symfony\Bundle\DoctrineMongoDBBundle\Tests\TestCase;

/**
 * @author Richard D Shank <develop@zestic.com>
 */
class InventoryManagerTest extends TestCase
{
    public function testAddToStock()
    {
        $mgr = $this->createInventoryManager();

        $inventory = $mgr->createInventory('product');

        $inventory = $mgr->addToInventory($inventory, 3);
        $this->assertSame(3, $inventory->getOnHand());
        $this->assertSame(3, $inventory->getAvailable());

        $inventory = $mgr->addToInventory($inventory, 3);
        $this->assertSame(6, $inventory->getOnHand());
        $this->assertSame(6, $inventory->getAvailable());

        // todo: set a location for the inventory
    }

    public function testRemoveFromStock()
    {
        $mgr = $this->createInventoryManager();

        $inventory = $mgr->createInventory('product');
        $mgr->addToInventory($inventory, 6);

        $inventory = $mgr->removeFromInventory($inventory, 3);
        $this->assertSame(3, $inventory->getOnHand());
        $this->assertSame(3, $inventory->getAvailable());

        // todo: set a location for the inventory

        // todo: remove from stock by passing in Reservation object

        $this->setExpectedException('RangeException');
        $inventory = $mgr->createInventory('product');
        $mgr->removeFromInventory($inventory, 6);
    }

    public function testReserve()
    {
        $mgr = $this->createInventoryManager();
        $inventory = $mgr->createInventory('product');
        $mgr->addToInventory($inventory, 6);

        $reservation = $mgr->reserve($inventory);
        $this->assertInstanceOf('\Vespolina\InventoryBundle\Model\ReservationInterface', $reservation);
        $this->assertSame(5, $inventory->getAvailable(), 'no items amount should default to 1');

        $mgr->reserve($inventory, 2);

        $this->assertSame(3, $inventory->getAvailable());
        $this->assertSame(6, $inventory->getOnHand());

        // todo: set a location for the inventory
    }

    public function testReleaseReserved()
    {
        // todo: set a location for the inventory
    }

    protected function createInventoryManager()
    {
        $inv = new InventoryManager(self::createTestDocumentManager(), '\Vespolina\InventoryBundle\Tests\Fixtures\Document\Inventory');


        return $inv;
    }
}
