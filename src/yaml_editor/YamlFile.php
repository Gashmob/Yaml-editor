<?php

namespace YamlEditor;

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
    }

    public function get_content()
    {
        return file_get_contents($this->filename);
    }
}