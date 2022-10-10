<?php

namespace Gashmob\YamlEditor\Test\Dump1;

use Gashmob\YamlEditor\Test\Test;
use Gashmob\YamlEditor\Yaml;

class Dump1Test implements Test
{

    /**
     * @inheritDoc
     */
    public function run()
    {
        $array = Yaml::parse('foo: bar');
        $result = Yaml::dump($array);

        return $result === "foo: bar\n";
    }
}