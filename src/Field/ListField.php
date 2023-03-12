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

namespace Gashmob\YamlEditor\Field;

/**
 * Represent a field with a list a value
 *
 * <code>
 * key:
 *   - value1
 *   - value2
 *   - value3
 * </code>
 */
class ListField extends Field
{
    /**
     * @param string          $key
     * @param (Field|mixed)[] $value
     * @param string|null     $tag
     */
    public function __construct(string $key, array $value, ?string $tag = null)
    {
        parent::__construct($key, $value, $tag);
    }

    public function __serialize(): array
    {
        return [
            $this->key => array_map(
                fn($value) => $value instanceof Field ? serialize($value) : $value,
                (array) $this->value
            ),
        ];
    }
}