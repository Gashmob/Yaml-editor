<?php

namespace Gashmob\YamlEditor;

final class Yaml
{
    /**
     * @param string $input
     * @return array
     */
    public static function parse($input)
    {
        return [];
    }

    /**
     * @param $filename
     * @return array
     */
    public static function parseFile($filename)
    {
        return [];
    }

    /**
     * @param array $input
     * @param int $indent
     * @return string
     */
    public static function dump($input, $indent = 4)
    {
        return '';
    }
}