<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\SitemapBundle\Tests\Sitemap;

use Nucleos\SitemapBundle\Definition\SitemapDefinition;
use Nucleos\SitemapBundle\Model\Url;
use Nucleos\SitemapBundle\Sitemap\SitemapServiceInterface;
use Nucleos\SitemapBundle\Sitemap\StaticSitemapService;
use Nucleos\SitemapBundle\Test\AbstractSitemapServiceTestCase;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class StaticSitemapServiceTest extends AbstractSitemapServiceTestCase
{
    public function testSitemap(): void
    {
        $sitemap = new SitemapDefinition('demo', [
            'priority'   => 20,
            'url'        => '/foo/bar',
            'changefreq' => Url::FREQUENCE_DAILY,
        ]);

        $optionResolver = new OptionsResolver();
        $this->service->configureSettings($optionResolver);

        $sitemap->setSettings($optionResolver->resolve($sitemap->getSettings()));

        $this->assertSitemap('/foo/bar', 20, Url::FREQUENCE_DAILY);

        $this->process($sitemap);
    }

    public function testExecuteWIthNoUrl(): void
    {
        $sitemap = new SitemapDefinition('demo', [
            'priority'   => 20,
            'url'        => null,
            'changefreq' => Url::FREQUENCE_DAILY,
        ]);

        $optionResolver = new OptionsResolver();
        $this->service->configureSettings($optionResolver);

        $sitemap->setSettings($optionResolver->resolve($sitemap->getSettings()));

        $this->assertSitemapCount(0);

        $this->process($sitemap);
    }

    protected function createService(): SitemapServiceInterface
    {
        return new StaticSitemapService();
    }
}
