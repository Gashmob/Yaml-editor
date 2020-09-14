<?php

namespace YamlEditor;

use YamlEditor\Exceptions\PathNotFoundException;

/**
 * Class YamlArray
 * This class represent a yaml array that you can modify with the set() method
 */
class YamlArray
{
    /**
     * The array that represent the yaml array
     * @var array
     */
    private $array;

    /**
     * YamlArray constructor.
     * Take a YamlFile and parse the yaml array to a php array
     * @param YamlFile $file
     * @see YamlParser
     * @see YamlFile
     */
    public function __construct(YamlFile $file)
    {
        $this->array = YamlParser::toArray($file);
    }

    /**
     * With this method you can modify the array
     * To do array[foo][bar] = 2
     * You must do set('foo.bar', 2);
     * @param string $path
     * @param $value
     */
    public function set($path, $value)
    {
        $this->array = YamlParser::getArray(explode('.', $path), $value, $this->array);
    }

    /**
     * Return the value math with the path
     * If the path doesn't exist, an exception is throw
     * @param string $path
     * @return mixed|string|array
     * @throws PathNotFoundException
     */
    public function get($path)
    {
        $tab = explode('.', $path);

        $value = '';
        $f = true;
        foreach ($tab as $word) {
            if ($f) {
                if (isset($this->array[$word])) {
                    $value = $this->array[$word];
                    $f = false;
                } else {
                    throw new PathNotFoundException();
                }
            } else {
                if (isset($value[$word])) {
                    $value = $value[$word];
                } else {
                    throw new PathNotFoundException();
                }
            }
        }

        return $value;
    }

    /**
     * Return the php array equivalent to the yaml array
     * @return array
     */
    public function getArray()
    {
        return $this->array;
    }
}