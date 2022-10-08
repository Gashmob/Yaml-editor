<?php

namespace Gashmob\YamlEditor\Test\Parse2;

use Gashmob\YamlEditor\Tag;
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

        return (string)Tag::fromArray($result) == '{foo: [{bar: baz}, {bar2: baz2}]}';
    }
}