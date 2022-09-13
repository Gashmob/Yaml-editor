<?php

namespace Gashmob\YamlEditor;

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

    public function get_content()
    {
        return file_get_contents($this->filename);
    }
}