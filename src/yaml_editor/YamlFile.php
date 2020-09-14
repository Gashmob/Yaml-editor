<?php

namespace YamlEditor;

use YamlEditor\Exceptions\NotYamlFileException;

/**
 * Class YamlFile
 * This class represent a yaml file (.yml)
 * It's with this class that you can open and edit .yml file
 */
class YamlFile
{
    /**
     * The file which is open
     * @var resource
     */
    private $file;

    /**
     * YamlFile constructor.
     * @param string $filename The path to the file
     * @throws NotYamlFileException If it's not a .yml file
     */
    public function __construct($filename)
    {
        if ($this->getExtension($filename) == 'yml') {
            if (file_exists($filename)) $this->file = fopen($filename, 'r+t');
            else $this->file = fopen($filename, 'x+t');
        } else throw new NotYamlFileException();
    }

    /**
     * Return an instance of YamlArray class
     * @return YamlArray
     * @see YamlArray
     */
    public function getYamlArray()
    {
        return new YamlArray($this);
    }

    /**
     * With this method you can change the file content with a new YamlArray
     * @param YamlArray $array
     * @see YamlArray
     */
    public function setYamlArray(YamlArray $array)
    {
        $s = YamlParser::toYaml($array);
        rewind($this->file);
        var_dump(ftruncate($this->file, 0));
        fwrite($this->file, $s);
    }

    /**
     * @return resource
     */
    public function getFile()
    {
        return $this->file;
    }

    // _.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-.

    /**
     * @param string $filename
     * @return string
     */
    private function getExtension($filename)
    {
        $extension = "";
        $i = strlen($filename) - 1;
        $c = $filename[$i];
        while ($c != '.' || $i == 0) {
            $extension = $c . $extension;

            $i--;
            $c = $filename[$i];
        }

        return $extension;
    }
}