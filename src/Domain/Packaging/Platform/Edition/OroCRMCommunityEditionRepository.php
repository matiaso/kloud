<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Packaging\Platform\Edition;

use Exception;
use Traversable;

final class OroCRMCommunityEditionRepository implements EditionRepositoryInterface, \IteratorAggregate
{
    public function getIterator()
    {
        yield new EditionDependency(
            'orocrm',
            '3.1',
            'ce',
            new Edition(
                'oroplatform',
                '3.1',
                'ce'
            )
        );

        yield new EditionDependency(
            'orocrm',
            '4.1',
            'ce',
            new Edition(
                'oroplatform',
                '4.1',
                'ce'
            )
        );
    }
}