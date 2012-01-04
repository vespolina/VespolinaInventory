<?php
/**
 * (c) 2011 - 2012 Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Vespolina\InventoryBundle\Tests\Fixtures\Document;

use Vespolina\InventoryBundle\Document\BaseInventory as BaseInventory;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @author Richard Shank <develop@zestic.com>
 */
/**
 * @ODM\Document(collection="vespolinaInventory")
 */
class Inventory extends BaseInventory
{
    /** @ODM\Id */
    protected $id;

    /** @ODM\Boolean */
    protected $inProgress;

    /** @ODM\Date */
    protected $processStarted;

    /** @ODM\String */
    protected $identifierSet;

    /**
     * @ODM\ReferenceOne(targetDocument="Vespolina\InventoryBundle\Tests\Fixtures\Document\Product")
     */
    protected $product;

    public function __construct($product, $identifierSet = null)
    {
        parent::__construct($product, $identifierSet);
    }

    public function getId()
    {
        return $this->id;
    }
}
