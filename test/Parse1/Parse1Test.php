<?php

namespace Gashmob\YamlEditor\Test\Parse1;

use Gashmob\YamlEditor\Component;
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

        return (string)Component::fromArray($result) == '{foo: bar}';
    }
}