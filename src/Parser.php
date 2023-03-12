<?php
/**
 * MIT License
 *
 * Copyright (c) 2023-Present Kevin Traini
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace Gashmob\YamlEditor;

use Gashmob\YamlEditor\Field\Field;

/**
 * Yaml Parser
 *
 * Take a string as input and returns an array of Field
 *
 * @see Field
 */
final class Parser
{
    /**
     * Parse the input string to an array of Field
     *
     * @param string $input
     * @return Field[]
     */
    public function parse(string $input): array
    {
        $lines = $this->prepare($input);

        return [];
    }

    // _.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-.
    // Utility functions

    /**
     * @param string $input
     * @return string[]
     */
    private function prepare(string $input): array
    {
        // Explode on \n
        $lines = explode("\n", $input);

        // rtrim
        $lines = array_map(
            fn($line) => rtrim($line),
            $lines
        );

        // Remove empty and spaces lines
        $lines = array_filter(
            $lines,
            fn($line) => !(empty($line) || preg_match('/^ +$/', $line))
        );

        return array_values($lines);
    }
}