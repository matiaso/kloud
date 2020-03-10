<?php

namespace spec\Builder\Package;

use Builder\Package\Edition;
use Builder\Package\EditionInterface;
use Builder\Package\Variation;
use Builder\Package\Version;
use Builder\Package\VersionInterface;
use Builder\PHP;
use Builder\Tag\DependentTagReference;
use Builder\Tag\TagReference;
use PhpSpec\ObjectBehavior;

class EditionSpec extends ObjectBehavior
{
    public function it_is_initializable(VersionInterface $version)
    {
        $this->beConstructedWith('ee', $version);

        $this->shouldHaveType(Edition::class);
        $this->shouldHaveType(EditionInterface::class);
    }

    public function it_is_iterable()
    {
        $v31 = new Version('3.1',
            new Variation('postgres', new PHP\Version('7.4', new PHP\Flavor('fpm'), new PHP\Flavor('cli'))),
            new Variation('mysql', new PHP\Version('7.4', new PHP\Flavor('fpm'), new PHP\Flavor('cli'))),
        );
        $v41 = new Version('4.1',
            new Variation('postgres', new PHP\Version('7.4', new PHP\Flavor('fpm'), new PHP\Flavor('cli'))),
            new Variation('mysql', new PHP\Version('7.4', new PHP\Flavor('fpm'), new PHP\Flavor('cli'))),
        );

        $this->beConstructedWith('ee', $v31, $v41);

        $this->shouldIterateTagsLike(new \ArrayIterator([
            new DependentTagReference(new TagReference('7.4-fpm-postgres'), '7.4-fpm-ee-3.1-postgres'),
            new DependentTagReference(new TagReference('7.4-cli-postgres'), '7.4-cli-ee-3.1-postgres'),
            new DependentTagReference(new TagReference('7.4-fpm-mysql'), '7.4-fpm-ee-3.1-mysql'),
            new DependentTagReference(new TagReference('7.4-cli-mysql'), '7.4-cli-ee-3.1-mysql'),
            new DependentTagReference(new TagReference('7.4-fpm-postgres'), '7.4-fpm-ee-4.1-postgres'),
            new DependentTagReference(new TagReference('7.4-cli-postgres'), '7.4-cli-ee-4.1-postgres'),
            new DependentTagReference(new TagReference('7.4-fpm-mysql'), '7.4-fpm-ee-4.1-mysql'),
            new DependentTagReference(new TagReference('7.4-cli-mysql'), '7.4-cli-ee-4.1-mysql'),
        ]));
    }
}
