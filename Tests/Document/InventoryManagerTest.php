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

        $inventory = $this->createInventory();

        $inventory = $mgr->addToStock($inventory, 3);
        $this->assertSame(3, $inventory->getOnHand());
        $this->assertSame(3, $inventory->getAvailable());

        $inventory = $mgr->addToStock($inventory, 3);
        $this->assertSame(6, $inventory->getOnHand());
        $this->assertSame(6, $inventory->getAvailable());

        // todo: set a location for the inventory
    }

    public function testReserve()
    {
        $inventory = $this->createInventory();
        $inventory->addToStock(6);

        $reservation = $inventory->reserve();
        $this->assertInstanceOf('\Vespolina\InventoryBundle\Model\ReservationInterface', $reservation);
        $this->assertSame(5, $inventory->getAvailable(), 'no items amount should default to 1');

        $inventory->reserve(2);

        $this->assertSame(3, $inventory->getAvailable());
        $this->assertSame(6, $inventory->getOnHand());

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
        $this->assertSame(3, $inventory->getOnHand());
        $this->assertSame(3, $inventory->getAvailable());

        // todo: set a location for the inventory

        // todo: remove from stock by passing in Reservation object

        $this->setExpectedException('RangeException');
        $inventory = $this->createInventory();
        $inventory->removeFromStock(6);
    }

    protected function createInventoryManager()
    {
        $inv = new InventoryManager(self::createTestDocumentManager(), '\Vespolina\InventoryBundle\Tests\Fixtures\Document\Inventory');

        return $inv;
    }

    protected function createInventory($product = null, $identifierSet = null)
    {
        $product = $product ? $product : 'product';
        $inv = new Inventory($product, $identifierSet);

        return $inv;
    }
}