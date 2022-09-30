<?php

namespace Gashmob\YamlEditor\Test\Read2;

use Gashmob\YamlEditor\exceptions\InvalidYamlException;
use Gashmob\YamlEditor\Test\Test;
use Gashmob\YamlEditor\YamlFile;

class Read2Test implements Test
{
    /**
     * @inheritDoc
     */
    public function run()
    {
        $file = new YamlFile(__DIR__ . '/myFile.yml');

        try {
            $array = $file->read();
        } catch (InvalidYamlException $e) {
            return false;
        }

        var_dump($array);

        $ref = [];

        return $array == $ref;
    }
}