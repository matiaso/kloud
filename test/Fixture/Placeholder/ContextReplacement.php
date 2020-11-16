<?php declare(strict_types=1);

namespace test\Kiboko\Cloud\Fixture\Placeholder;

use test\Kiboko\Cloud\Fixture\FixtureProviderInterface;
use test\Kiboko\Cloud\Fixture\PlaceholderInterface;

final class ContextReplacement implements PlaceholderInterface
{
    private string $pattern;
    private ?FixtureProviderInterface $context;

    public function __construct(string $pattern)
    {
        $this->pattern = $pattern;
        $this->context = null;
    }

    public function setContext(FixtureProviderInterface $context)
    {
        $this->context = $context;
    }

    public function matches(FixtureProviderInterface $context, string $value, string $phpVersion, string $applicationVersion)
    {
        return $value === strtr($this->pattern, [
            '%phpVersion%' => $phpVersion,
            '%application%' => $context->getApplication(),
            '%applicationVersion%' => $applicationVersion,
            '%applicationEdition%' => $context->isEnterpriseEdition() ? 'ee' : 'ce',
            '%dbms%' => $context->getDBMS(),
        ]);
    }
}
