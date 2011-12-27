<?php
/**
 * (c) Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Vespolina\InventoryBundle\Model;

use Vespolina\InventoryBundle\Model\InventoryInterface;
use Vespolina\ProductBundle\Model\Identifier\IdentifierInterface;  //TODO move to CoreBundle

/**
 * @author Daniel Kucharski <daniel@xerias.be>
 * @author Richard Shank <develop@zestic.com>
 */
abstract class Inventory implements InventoryInterface
{
    protected $available;
    protected $detailedCount;
    protected $identifier;
    protected $identifierSet;
    protected $onHand;
    protected $product;
    protected $updatedAt;

    public function __construct($product, $identifierSet = null)
    {
        $this->product = $product;
        $this->identifierSet = $identifierSet;
    }

    /**
     * @inheritdoc
     */
    function getDetailedCount($granularity)
    {

        return $this->detailedCount;
    }

    /**
     * @inheritdoc
     */
    function getIdentifier()
    {

        return $this->identifier;
    }

    /**
     * @inheritdoc
     */
    function getUpdatedAt()
    {

        return $this->updatedAt;
    }

    /**
     * @inheritdoc
     */
    function setIdentifier(IdentifierInterface $identifier)
    {

        $this->identifier = $identifier;
    }

    /**
     * @inheritdoc
     */
    public function getAvailable()
    {
        return $this->available;
    }

    /**
     * @inheritdoc
     */
    public function getOnHand()
    {
        return $this->onHand;
    }
}
