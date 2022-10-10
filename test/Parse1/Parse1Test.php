<?php

namespace Gashmob\YamlEditor\Test\Parse1;

use Gashmob\YamlEditor\Tag;
use Gashmob\YamlEditor\Test\Test;
use Gashmob\YamlEditor\Yaml;

class Parse1Test implements Test
{
    /**
     * @inheritDoc
     */
    public function run()
    {
        $result = Yaml::parse('foo: bar');

        return (string)Tag::fromArray($result) == '{foo: bar}';
    }
}