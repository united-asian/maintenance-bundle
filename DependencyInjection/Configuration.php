<?php

namespace UAM\Bundle\MaintenanceBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('uam_maintenance');

        $rootNode
            ->children()
                ->arrayNode('listener')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('class')
                            ->cannotBeEmpty()
                            ->defaultValue('UAM\Bundle\MaintenanceBundle\EventListener\MaintenanceListener')
                        ->end()
                        ->integerNode('priority')
                            ->defaultValue(255)
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
