<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\SitemapBundle\Definition;

final class SitemapDefinition implements SitemapDefinitionInterface
{
    /**
     * @var array<string, mixed>
     */
    private $settings;

    /**
     * @var string
     */
    private $type;

    /**
     * @param array<string, mixed> $settings
     */
    public function __construct(string $type, array $settings = [])
    {
        $this->settings = $settings;
        $this->type     = $type;
    }

    public function __toString()
    {
        return $this->toString();
    }

    public function toString(): string
    {
        return $this->getType();
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setSettings(array $settings = []): void
    {
        $this->settings = $settings;
    }

    public function getSettings(): array
    {
        return $this->settings;
    }

    public function getSetting(string $name, $default = null)
    {
        return $this->settings[$name] ?? $default;
    }

    public function getTtl(): int
    {
        if (true !== $this->getSetting('use_cache', true)) {
            return 0;
        }

        return (int) $this->getSetting('ttl', 0);
    }
}
