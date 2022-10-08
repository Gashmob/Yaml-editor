<?php

namespace Gashmob\YamlEditor\Test\ComponentAsArray1;

use Gashmob\YamlEditor\Tag;
use Gashmob\YamlEditor\Test\Test;

class ComponentAsArray1Test implements Test
{
    /**
     * @inheritDoc
     */
    public function run()
    {
        $comp = new Tag('foo', 'bar');

        $a = $comp->asArray();

        return $a == ['foo' => 'bar'];
    }
}