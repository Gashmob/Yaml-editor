<?php

namespace Gashmob\YamlEditor\Test\Parse2;

use Gashmob\YamlEditor\Component;
use Gashmob\YamlEditor\Test\Test;
use Gashmob\YamlEditor\Yaml;

class Parse2Test implements Test
{
    /**
     * @inheritDoc
     */
    public function run()
    {
        $result = Yaml::parseFile(__DIR__ . '/test.yml');

        return (string)Component::fromArray($result) == '{foo: [{bar: baz}, {bar2: baz2}]}';
    }
}