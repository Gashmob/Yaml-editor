<?php

namespace YamlEditor;

use YamlEditor\Exceptions\FileNotOpenException;
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
     * @var string
     */
    private $content;

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
     * @throws FileNotOpenException
     * @see YamlArray
     */
    public function getYamlArray()
    {
        return new YamlArray($this);
    }

    /**
     * With this method you can change the file content with a new YamlArray
     * @param YamlArray $array
     * @throws FileNotOpenException
     * @see YamlArray
     */
    public function setYamlArray(YamlArray $array)
    {
        $s = YamlParser::toYaml($array);
        $this->content = $s;
        ftruncate($this->getFile(), 0);
        fwrite($this->getFile(), $this->getContent());
    }

    /**
     * @return resource
     * @throws FileNotOpenException
     */
    public function getFile()
    {
        if ($this->file === null) {
            throw new FileNotOpenException();
        }

        return $this->file;
    }

    /**
     * @return string
     * @throws FileNotOpenException
     */
    public function getContent()
    {
        if ($this->content === null) {
            $this->content = fread($this->getFile(), filesize($this->getFile()));
        }

        return $this->content;
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