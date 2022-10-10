<?php

namespace Gashmob\YamlEditor\Test\Parse5;

use Gashmob\YamlEditor\Tag;
use Gashmob\YamlEditor\Test\Test;
use Gashmob\YamlEditor\Yaml;

class Parse5Test implements Test
{
    /**
     * @inheritDoc
     */
    public function run()
    {
        $array = Yaml::parseFile(__DIR__ . '/test.yml');
        $tags = Tag::fromArray($array);

        return $tags instanceof Tag && (string)$tags == '{foo: bar}';
    }
}