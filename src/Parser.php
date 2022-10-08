<?php

namespace Gashmob\YamlEditor;

class Parser
{
    /**
     * Parse a string formatted as YAML into a PHP array.
     *
     * @param string $input
     * @return array
     */
    public function parse($input)
    {
        $lines = $this->prepare($input);

        $array = $this->doParse($lines);

        $result = [];
        foreach ($array as $comp) {
            $c = $comp->asArray();
            $result[key($c)] = current($c);
        }

        return $result;
    }

    // _.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-.

    /**
     * Prepare the input string for parsing.
     * - Explode on \n
     * - rtrim
     * - remove empty lines (and spaces lines)
     * - move all lines to left to reduce root indentation to 0
     *
     * @param string $input
     * @return array
     */
    private function prepare($input)
    {
        // Explode on \n
        $result = explode("\n", $input);

        // rtrim
        foreach ($result as $key => $line) {
            $result[$key] = rtrim($line);
        }

        // remove empty lines (and spaces lines)
        $result = array_filter($result, function ($line) {
            if (empty($line)) {
                return false;
            }
            if (preg_match('/^ +$/', $line)) {
                return false;
            }
            return true;
        });

        // Move all lines to left to reduce root indentation to 0
        $result = $this->reduceIndent($result);

        return array_values($result);
    }

    /**
     * @param string[] $lines
     * @return string[]
     */
    private function reduceIndent($lines)
    {
        $minIndent = $this->getMinIndent($lines);
        $result = [];
        foreach ($lines as $line) {
            $result[] = substr($line, $minIndent);
        }

        return $result;
    }

    /**
     * @param string[] $lines
     * @return int
     */
    private function getMinIndent($lines)
    {
        if (empty($lines)) {
            return 0;
        }

        $minIndent = $this->getIndent($lines[0]);
        foreach ($lines as $line) {
            $indent = $this->getIndent($line);
            if ($indent < $minIndent) {
                $minIndent = $indent;
            }
        }

        return $minIndent;
    }

    /**
     * Count the number of spaces at the beginning of a string.
     *
     * @param string $line
     * @return int
     */
    private function getIndent($line)
    {
        $indent = 0;
        for ($i = 0; $i < strlen($line); $i++) {
            if ($line[$i] === ' ') {
                $indent++;
            } else {
                break;
            }
        }

        return $indent;
    }

    /**
     * Parse the lines into an array of components.
     *
     * @param string[] $lines
     * @return Component[]|array|string
     */
    private function doParse($lines)
    {
        // Collect all tags and associate them their lines
        $tags = [];
        $currentTag = null;
        $childLines = [];
        foreach ($lines as $line) {
            $indent = $this->getIndent($line);
            if ($indent === 0) {
                if ($line[0] == '|') { // multiline
                    return $lines;
                } else if ($line[0] == '-') { // list
                    return $this->parseList($lines);
                } else if ($line[0] == '>') { // block
                    $lines[0][0] = ' ';
                    return trim(implode(' ', $lines));
                } else if (!strstr($line, ':')) { // value
                    assert(count($lines) === 1);
                    return $line;
                } else { // It's a tag
                    if ($currentTag !== null) {
                        $tags[$currentTag] = $childLines;
                        $childLines = [];
                    }
                    $tv = explode(':', $line, 2);
                    $currentTag = $tv[0];
                    if ($tv[1] != '') {
                        $childLines[] = $tv[1];
                    }
                }
            } else {
                $childLines[] = $line;
            }
        }

        if ($currentTag !== null) {
            $tags[$currentTag] = $childLines;
        }

        // Transform all tags into Components and use doParse() recursively on their values
        $components = [];
        foreach ($tags as $tag => $childLines) {
            $components[] = new Component($tag, $this->doParse($this->reduceIndent($childLines)));
        }

        return $components;
    }

    /**
     * Parse the lines as a list
     *
     * @param string[] $lines
     * @return array
     */
    private function parseList($lines)
    {
        $result = [];

        $item = [];
        $inItem = false;
        foreach ($lines as $line) {
            if ($line[0] == '-') {
                if ($inItem) {
                    $result[] = $this->doParse($item);
                    $item = [];
                }
                $inItem = true;
                $item[] = substr($line, 1);
            } else {
                $item[] = $line;
            }
        }

        return $result;
    }
}