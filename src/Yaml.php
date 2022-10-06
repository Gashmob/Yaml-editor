<?php

namespace Gashmob\YamlEditor;

use InvalidArgumentException;

final class Yaml
{
    /**
     * @param string $input
     * @return array
     */
    public static function parse($input)
    {
        $parser = new Parser();

        return $parser->parse($input);
    }

    /**
     * @param $filename
     * @return array
     * @throws InvalidArgumentException
     */
    public static function parseFile($filename)
    {
        if (!file_exists($filename)) {
            throw new InvalidArgumentException("File '$filename' does not exist.");
        }
        if (!is_readable($filename)) {
            throw new InvalidArgumentException("File '$filename' is not readable.");
        }

        return self::parse(file_get_contents($filename));
    }

    /**
     * @param array $input
     * @param int $indent
     * @return string
     */
    public static function dump($input, $indent = 4)
    {
        $dumper = new Dumper();

        return $dumper->dump($input, $indent);
    }
}