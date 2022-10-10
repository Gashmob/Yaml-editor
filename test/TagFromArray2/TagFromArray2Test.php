<?php

namespace Gashmob\YamlEditor\Test\TagFromArray2;

use Gashmob\YamlEditor\Tag;
use Gashmob\YamlEditor\Test\Test;

class TagFromArray2Test implements Test
{

    /**
     * @inheritDoc
     */
    public function run()
    {
        $a = ['foo' => [
            'bar' => 'baz',
            'bar2' => 'baz2',
        ]];
        $comp = Tag::fromArray($a);

        return (string)$comp == '{foo: [{bar: baz}, {bar2: baz2}]}';
    }
}