<?php

namespace Gashmob\YamlEditor\Test\File;

use Gashmob\YamlEditor\Test\Test;
use Gashmob\YamlEditor\YamlFile;

class FileTest implements Test
{
    /**
     * @inheritDoc
     */
    public function run()
    {
        $file = new YamlFile(__DIR__ . '/myFile.yml');

        return $file->get_content() == 'hello: "world!"';
    }
}