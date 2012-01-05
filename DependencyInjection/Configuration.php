<?php
/**
 * (c) 2011 - 2012 Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Vespolina\InventoryBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @author Richard Shank <develop@zestic.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree.
     *
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('vespolina_inventory');
        $rootNode
            ->children()
                ->scalarNode('db_driver')->cannotBeOverwritten()->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('inventory_class')->end()
            ->end();

        $this->addInventoryManagerSection($rootNode);

        return $treeBuilder;
    }

    private function addInventoryManagerSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('inventory_manager')
                ->children()
                    ->scalarNode('manager_class')->end()
                ->end()
                ->end()
            ->end()
        ;
    }
}
