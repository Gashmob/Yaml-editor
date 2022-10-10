<?php

namespace Gashmob\YamlEditor;

use InvalidArgumentException;

class Dumper
{
    /**
     * Dump an array to YAML.
     *
     * @param array $input
     * @param int $indent Number of spaces for indentation
     * @return string
     */
    public function dump($input, $indent = 4)
    {
        if (!is_array($input)) {
            throw new InvalidArgumentException('Input must be an array');
        }

        $output = '';

        $tags = Tag::fromArray($input);

        if (is_array($tags)) {
            foreach ($tags as $tag) {
                $output .= $tag->dump($indent);
            }
        } else {
            $output .= $tags->dump($indent);
        }

        return $output;
    }
}