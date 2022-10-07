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

        return [];
    }

    // _.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-.

    /**
     * Prepare the input string for parsing.
     * - Explode on \n
     * - rtrim
     * - remove empty lines
     *
     * @param string $input
     * @return array
     */
    private function prepare($input)
    {
        $result = explode("\n", $input);

        foreach ($result as $key => $line) {
            $result[$key] = rtrim($line);
            if (empty($result[$key])) {
                unset($result[$key]);
            }
        }

        return $result;
    }
}