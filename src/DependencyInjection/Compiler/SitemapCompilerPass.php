<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\SitemapBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class SitemapCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container): void
    {
        $manager = $container->getDefinition('core23_sitemap.service.manager');

        foreach ($container->findTaggedServiceIds('core23.sitemap') as $id => $attributes) {
            $definition = $container->getDefinition($id);
            $definition->setPublic(true);

            $manager->addMethodCall('addSitemap', [new Reference($id)]);
        }
    }
}
