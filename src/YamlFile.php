<?php

namespace Gashmob\YamlEditor;

use Gashmob\YamlEditor\exceptions\InvalidYamlException;

class YamlFile
{
    /**
     * @var string
     */
    private $filename;

    /**
     * @param string $filename
     */
    public function __construct($filename)
    {
        $this->filename = $filename;
        if (!file_exists($filename)) {
            $file = fopen($filename, 'w');
            fclose($file);
        }
    }

    /**
     * @return false|string
     */
    public function get_content()
    {
        return file_get_contents($this->filename);
    }

    /**
     * @return array
     * @throws InvalidYamlException
     */
    public function read()
    {
        return YamlParser::yamlToArray($this->get_content());
    }
}