<?php

namespace YamlEditor;

/**
 * Class YamlParser
 * This class parse yaml array to php array and vice versa
 */
abstract class YamlParser
{
    /**
     * Parse a yaml array to a php array
     * @param YamlFile $file
     * @return array
     * @see YamlFile
     */
    public static function toArray(YamlFile $file)
    {
        return yaml_parse(fread($file->getFile(), filesize($file->getFile())));
    }

    /**
     * Parse a php array to a yaml array
     * @param YamlArray $yamlArray
     * @return string
     * @see YamlArray
     */
    public static function toYaml(YamlArray $yamlArray)
    {
        return yaml_emit($yamlArray->getArray());
    }

    // _.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-.

    /**
     * @param array $path
     * @param $value
     * @return array
     */
    public static function setArray(array $path, $value)
    {
        if (count($path) == 1) {
            $result[$path[0]] = $value;
        } elseif (count($path) > 1) {
            $result[$path[0]] = self::setArray(array_slice($path, 1), $value);
        } else { // count($path) == 0
            $result = [$value];
        }

        return $result;
    }

    /**
     * @param array $path
     * @param $value
     * @param array $array
     * @return array
     */
    public static function getArray(array $path, $value, array $array)
    {
        if (count($path) == 1) {
            $array[$path[0]] = $value;
        } elseif (count($path) > 0) {
            if (isset($array[$path[0]])) {
                $array[$path[0]] = self::getArray(array_slice($path, 1), $value, $array[$path[0]]);
            } else {
                $array = array_merge($array, self::setArray($path, $value));
            }
        }

        return $array;
    }
}