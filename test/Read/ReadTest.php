<?php

namespace Gashmob\YamlEditor\Test\Read;

use Gashmob\YamlEditor\exceptions\InvalidYamlException;
use Gashmob\YamlEditor\Test\Test;
use Gashmob\YamlEditor\YamlFile;

class ReadTest implements Test
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

        return $array['hello'] == 'world!';
    }
}