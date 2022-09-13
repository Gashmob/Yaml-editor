<?php

namespace Gashmob\YamlEditor;

use Gashmob\YamlEditor\exceptions\InvalidYamlException;

abstract class YamlParser
{
    const INDENT = '  '; // 2 spaces

    const KEY = /** @lang PhpRegExp */
        '/^( {2})*([a-zA-Z\d].*?):$/';
    const KEY_VALUE = /** @lang PhpRegExp */
        '/^( {2})*([a-zA-Z\d].*?): *([^ ].*)$/';
    const ITEM = /** @lang PhpRegExp */
        '/^( {2})*- ([^ ].*)$/';
    const VALUE = /** @lang PhpRegExp */
        '/^( {2})*([^ ].*)$/';


    /**
     * @param string $yaml
     * @return array
     * @throws InvalidYamlException
     */
    public static function yamlToArray($yaml)
    {
        $lines = explode("\n", $yaml);

        $result = [];

        $path = [];
        for ($i = 0; $i < count($lines); $i++) {
            $line = rtrim($lines[$i]);

            $matches = [];
            if (preg_match(self::KEY, $line, $matches)) {
                $level = strlen($matches[1]) / 2;
                if ($level != count($path)) {
                    $path = array_slice($path, 0, $level);
                }
                $path[] = $matches[2];
            } else if (preg_match(self::KEY_VALUE, $line, $matches)) {
                $level = strlen($matches[1]) / 2;
                if ($level != count($path)) {
                    $path = array_slice($path, 0, $level);
                }
                $path[] = $matches[2];
                $result = self::setValue($result, join('.', $path), $matches[3]);
                $path = array_slice($path, 0, -1);
            } else if (preg_match(self::ITEM, $line, $matches)) {
                $level = strlen($matches[1]) / 2;
                if ($level != count($path)) {
                    throw new InvalidYamlException($i, $line, "Invalid indentation");
                }
                $result = self::addValue($result, join('.', $path), $matches[2]);
            } else if (preg_match(self::VALUE, $line, $matches)) {
                $result = self::setValue($result, join('.', $path), $matches[2]);
                $path = array_slice($path, 0, -1);
            } else {
                throw new InvalidYamlException($i, $line, "Invalid line");
            }
        }

        return $result;
    }

    // _.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-.

    /**
     * @param array $array
     * @param string $path
     * @param string $value
     * @return array
     */
    private static function setValue($array, $path, $value)
    {
        $keys = explode('.', $path);
        $key = array_shift($keys);

        if (count($keys) == 0) {
            $array[$key] = self::parseValue($value);
        } else {
            if (!isset($array[$key])) {
                $oldValue = $array[$key];
                if (is_array($oldValue)) {
                    $array[$key] = self::setValue($oldValue, join('.', $keys), $value);
                } else {
                    $array[$key] = self::setValue([$oldValue], join('.', $keys), $value);
                }
            } else {
                $array[$key] = self::setValue($array, join('.', $keys), $value);
            }
        }

        return $array;
    }

    /**
     * @param array $array
     * @param string $path
     * @param string $value
     * @return array
     */
    private static function addValue($array, $path, $value)
    {
        $keys = explode('.', $path);
        $key = array_shift($keys);

        if (count($keys) == 0) {
            if (!isset($array[$key])) {
                $array[$key] = [self::parseValue($value)];
            } else {
                $array[$key][] = self::parseValue($value);
            }
        } else {
            if (!isset($array[$key])) {
                $oldValue = $array[$key];
                if (is_array($oldValue)) {
                    $array[$key] = self::addValue($oldValue, join('.', $keys), $value);
                } else {
                    $array[$key] = self::addValue([$oldValue], join('.', $keys), $value);
                }
            } else {
                $array[$key] = self::addValue($array, join('.', $keys), $value);
            }
        }

        return $array;
    }

    /**
     * @param string $value
     * @return bool|float|int|string|null|array
     */
    private static function parseValue($value)
    {
        if (is_numeric($value)) {
            return $value + 0;
        } else if (strtolower($value) == 'true') {
            return true;
        } else if (strtolower($value) == 'false') {
            return false;
        } else if (strtolower($value) == 'null') {
            return null;
        } else if (preg_match("/^\[.*]$/", $value)) {
            $array = explode(',', substr($value, 1, -1));
            return array_map("Gashmob\\YamlEditor\\YamlParser::parseValue", $array);
        } else if (preg_match("/^\".*\"$/", $value)) {
            return substr($value, 1, -1);
        } else {
            return $value;
        }
    }
}