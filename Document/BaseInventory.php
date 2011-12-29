<?php
/**
 * (c) Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Vespolina\InventoryBundle\Document;

use Vespolina\InventoryBundle\Model\Inventory as AbstractInventory;
use Vespolina\ProductBundle\Model\Identifier\IdentifierInterface;  //TODO move to CoreBundle

/**
 * @author Daniel Kucharski <daniel@xerias.be>
 * @author Richard Shank <develop@zestic.com>
 */
abstract class BaseInventory extends AbstractInventory
{
    protected $inProgress;

    public function __construct($product, $identifierSet = null)
    {
        parent::__construct($product, $identifierSet);
        $this->inProgress = false;
    }

}
