<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\SitemapBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('core23_sitemap');

        /* @var ArrayNodeDefinition $rootNode */
        // Keep compatibility with symfony/config < 4.2
        if (!\method_exists($treeBuilder, 'getRootNode')) {
            $rootNode = $treeBuilder->root('core23_sitemap');
        } else {
            $rootNode = $treeBuilder->getRootNode();
        }

        $this->addStaticUrlsSection($rootNode);
        $this->addCacheSection($rootNode);

        return $treeBuilder;
    }

    /**
     * @param ArrayNodeDefinition $node
     */
    private function addCacheSection(ArrayNodeDefinition $node): void
    {
        $node
            ->children()
                ->arrayNode('cache')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('service')->defaultNull()->end()
                    ->end()
                ->end()
            ->end()
        ;
    }

    /**
     * @param ArrayNodeDefinition $node
     */
    private function addStaticUrlsSection(ArrayNodeDefinition $node): void
    {
        $node
            ->children()
                ->arrayNode('static')
                    ->defaultValue([])
                    ->prototype('array')
                        ->children()
                             ->scalarNode('url')->end()
                             ->integerNode('priority')->defaultNull()->end()
                             ->scalarNode('changefreq')->defaultNull()->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
