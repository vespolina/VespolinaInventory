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
    protected $detailedCount;
    protected $identifier;
    protected $count;
    protected $updatedAt;

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
    function getCount()
    {

        return $this->count;
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
    function setDetailedCount($detailedCount)
    {
        $this->detailedCount = $detailedCount;
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
    public function addToStock($items, $location = null)
    {
        $this->count += (int)$items;
        if ($location) {
            throw new \Exception('not implemented');
        }
    }

}
