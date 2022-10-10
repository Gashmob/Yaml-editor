<?php

namespace Gashmob\YamlEditor\Test\Dump2;

use Gashmob\YamlEditor\Test\Test;
use Gashmob\YamlEditor\Yaml;

require_once __DIR__ . '/../Test.php';

class Dump2Test implements Test
{

    /**
     * @inheritDoc
     */
    public function run()
    {
        $array = Yaml::parseFile(__DIR__ . '/test.yml');
        $result = Yaml::dump($array, 2);

        return $result == (file_get_contents(__DIR__ . '/test.yml') . "\n");
    }
}