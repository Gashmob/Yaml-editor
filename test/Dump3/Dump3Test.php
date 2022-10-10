<?php

namespace Gashmob\YamlEditor\Test\Dump3;

use Gashmob\YamlEditor\Test\Test;
use Gashmob\YamlEditor\Yaml;

class Dump3Test implements Test
{

    /**
     * @inheritDoc
     */
    public function run()
    {
        $array = Yaml::parseFile(__DIR__ . '/test.yml');
        $result = Yaml::dump($array, 2);

        return $result == file_get_contents(__DIR__ . '/result.yml');
    }
}