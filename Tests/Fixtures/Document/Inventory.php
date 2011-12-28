<?php
/**
 * (c) 2011 - 2012 Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Vespolina\InventoryBundle\Tests\Fixtures\Document;

use Vespolina\InventoryBundle\Model\Inventory as BaseInventory;
use Vespolina\ProductBundle\Model\Identifier\IdentifierInterface;  //TODO move to CoreBundle

/**
 * @author Richard Shank <develop@zestic.com>
 */
class Inventory extends BaseInventory
{
    public function __construct($product, $identifierSet = null)
    {
        parent::__construct($product, $identifierSet);
    }
}
