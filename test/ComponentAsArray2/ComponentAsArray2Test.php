<?php

namespace Gashmob\YamlEditor\Test\ComponentAsArray2;

use Gashmob\YamlEditor\Component;
use Gashmob\YamlEditor\Test\Test;

class ComponentAsArray2Test implements Test
{
    /**
     * @inheritDoc
     */
    public function run()
    {
        $comp = new Component('foo', [
            new Component('bar', 'baz'),
            new Component('bar2', 'baz2'),
        ]);

        $a = $comp->asArray();

        return $a == ['foo' => [
                ['bar' => 'baz'],
                ['bar2' => 'baz2'],
            ]];
    }
}