<?php

namespace Gashmob\YamlEditor\Test\TagAsArray2;

use Gashmob\YamlEditor\Tag;
use Gashmob\YamlEditor\Test\Test;

class TagAsArray2Test implements Test
{
    /**
     * @inheritDoc
     */
    public function run()
    {
        $comp = new Tag('foo', [
            new Tag('bar', 'baz'),
            new Tag('bar2', 'baz2'),
        ]);

        $a = $comp->asArray();

        return $a == ['foo' => [
                'bar' => 'baz',
                'bar2' => 'baz2',
            ]];
    }
}