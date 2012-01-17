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
use Vespolina\InventoryBundle\Tests\Fixtures\Document\Product;

use Doctrine\Bundle\MongoDBBundle\Tests\TestCase;

/**
 * @author Richard D Shank <develop@zestic.com>
 */
class InventoryManagerTest extends TestCase
{
    protected $dm;

    public function setUp()
    {
        $this->dm = self::createTestDocumentManager();
    }

    public function tearDown()
    {
        $collections = $this->dm->getDocumentCollections();
        foreach ($collections as $collection) {
            $collection->drop();
        }
    }

    public function testAddToStock()
    {
        $mgr = $this->createInventoryManager();

        $inventory = $mgr->createInventory($this->createProduct('product'));

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

        $inventory = $mgr->createInventory($this->createProduct('product'));
        $mgr->addToInventory($inventory, 6);

        $inventory = $mgr->removeFromInventory($inventory, 3);
        $this->assertSame(3, $inventory->getOnHand());
        $this->assertSame(3, $inventory->getAvailable());

        // todo: set a location for the inventory

        // todo: remove from stock by passing in Reservation object

        $this->setExpectedException('RangeException');
        $inventory = $mgr->createInventory($this->createProduct('product'));
        $mgr->removeFromInventory($inventory, 6);
    }

    public function testReserve()
    {
        $this->markTestIncomplete('reserving items has not been implemented yet');

        $mgr = $this->createInventoryManager();
        $inventory = $mgr->createInventory($this->createProduct('product'));
        $mgr->addToInventory($inventory, 6);

        $reservation = $mgr->reserve($inventory, 'order');
        $this->assertInstanceOf('\Vespolina\InventoryBundle\Model\ReservationInterface', $reservation);
        $this->assertSame(5, $inventory->getAvailable(), 'no items amount should default to 1');

        $mgr->reserve($inventory, 'order', 2);

        $this->assertSame(3, $inventory->getAvailable());
        $this->assertSame(6, $inventory->getOnHand());

        // todo: set a location for the inventory
    }

    public function testReleaseReserved()
    {
        // todo: set a location for the inventory
    }

    public function testSetOnHandInventory()
    {
        $mgr = $this->createInventoryManager();

        $inventory = $mgr->createInventory($this->createProduct('product'));
        $mgr->addToInventory($inventory, 3);

        $inventory = $mgr->setInventoryOnHand($inventory, 6);
        $this->assertSame(6, $inventory->getOnHand());
        $this->assertSame(6, $inventory->getAvailable());

        $this->markTestIncomplete('reserving items has not been implemented yet');

        $mgr->reserve($inventory, 'order');
        $inventory = $mgr->setOnHandInventory($inventory, 8);
        $this->assertSame(8, $inventory->getOnHand());
        $this->assertSame(7, $inventory->getAvailable());

        $this->setExpectedException('RangeException');
        $mgr->reserve($inventory, 'order', 3);
        $mgr->setOnHandInventory($inventory, 2);
    }

    public function testFindInventoryForProduct()
    {
        $mgr = $this->createInventoryManager();
        $product = $this->createProduct('test');
        $alpha = $mgr->createInventory($product, 'alpha');
        $mgr->addToInventory($alpha, 3);
        $beta = $mgr->createInventory($product, 'beta');
        $mgr->addToInventory($beta, 4);

        $inventory = $mgr->findInventoryForProduct($product, 'alpha');
        $this->assertEquals($alpha->getId(), $inventory->getId(), 'load a single result when identifier passed');

        $inventory = $mgr->findInventoryForProduct($product);
        $this->assertSame(2, $inventory->count());
    }

    protected function createInventoryManager()
    {
        $inv = new InventoryManager($this->dm, '\Vespolina\InventoryBundle\Tests\Fixtures\Document\Inventory');

        return $inv;
    }

    protected function createProduct($name)
    {
        $product = new Product();
        $product->setName($name);

        $this->dm->persist($product);
        $this->dm->flush();

        return $product;
    }
}
