<?php

namespace Gashmob\YamlEditor\Test\ComponentFromArray1;

use Gashmob\YamlEditor\Component;
use Gashmob\YamlEditor\Test\Test;

class ComponentFromArray1Test implements Test
{
    /**
     * @inheritDoc
     */
    public function run()
    {
        $a = ['foo' => 'bar'];
        $comp = Component::fromArray($a);

        return (string)$comp == '{foo: bar}';
    }
}