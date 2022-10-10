<?php

namespace Gashmob\YamlEditor\Test\TagFromArray1;

use Gashmob\YamlEditor\Tag;
use Gashmob\YamlEditor\Test\Test;

class TagFromArray1Test implements Test
{
    /**
     * @inheritDoc
     */
    public function run()
    {
        $a = ['foo' => 'bar'];
        $comp = Tag::fromArray($a);

        return (string)$comp == '{foo: bar}';
    }
}