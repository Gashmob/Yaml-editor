<?php

namespace Gashmob\YamlEditor\Test\ComponentFromArray2;

use Gashmob\YamlEditor\Tag;
use Gashmob\YamlEditor\Test\Test;

class ComponentFromArray2Test implements Test
{

    /**
     * @inheritDoc
     */
    public function run()
    {
        $a = ['foo' => [
            ['bar' => 'baz'],
            ['bar2' => 'baz2'],
        ]];
        $comp = Tag::fromArray($a);

        return (string)$comp == '{foo: [{bar: baz}, {bar2: baz2}]}';
    }
}