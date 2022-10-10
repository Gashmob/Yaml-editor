<?php

namespace Gashmob\YamlEditor;

use InvalidArgumentException;

class Tag
{
    /**
     * @var string
     */
    private $tag;
    /**
     * @var mixed
     */
    private $value;

    /**
     * @param string $tag
     * @param mixed $value
     */
    public function __construct($tag, $value)
    {
        $this->tag = $tag;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return array
     */
    public function asArray()
    {
        $v = $this->value;
        if ($this->value instanceof Tag) {
            $v = $this->value->asArray();
        } else if (is_array($this->value)) {
            $v = [];
            foreach ($this->value as $item) {
                if ($item instanceof Tag) {
                    $ar = $item->asArray();
                    $v[key($ar)] = current($ar);
                } else if (is_array($item)) {
                    $sub = [];
                    foreach ($item as $subItem) {
                        if ($subItem instanceof Tag) {
                            $ar = $subItem->asArray();
                            $sub[key($ar)] = current($ar);
                        } else {
                            $sub[] = $subItem;
                        }
                    }
                    $v[] = $sub;
                } else {
                    $v[] = $item;
                }
            }
        }

        return [$this->tag => $v];
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $res = "{{$this->tag}: ";

        if (is_array($this->value)) {
            $res .= $this->__arrayToString($this->value);
        } else {
            $res .= $this->value;
        }

        return $res . '}';
    }

    /**
     * @param array $array
     * @return string
     */
    private function __arrayToString($array)
    {
        $res = '[';

        foreach ($array as $item) {
            if (is_array($item)) {
                $res .= $this->__arrayToString($item);
            } else {
                $res .= $item;
            }
            // Add comma if not last item
            if ($item !== end($array)) {
                $res .= ', ';
            }
        }

        return $res . ']';
    }

    /**
     * Dump the tag to YAML.
     *
     * @param int $indent Number of spaces for indentation
     * @param int $times Indentation level (used for recursion)
     * @param bool $firstIdent If doing the first indent or not (used for recursion)
     * @return string
     */
    public function dump($indent = 4, $times = 0, $firstIdent = true)
    {
        $output = '';
        if ($firstIdent) {
            $output .= str_repeat(' ', $times * $indent);
        }
        $output .= $this->tag . ':';

        if (is_array($this->value)) {
            if ($this->isPartialList($this->value)) {
                $output .= "\n";
                foreach ($this->value as $item) {
                    $output .= str_repeat(' ', ($times + 1) * $indent) . '- ';
                    if (is_array($item)) {
                        $first = true;
                        foreach ($item as $subItem) {
                            if ($first) {
                                $first = false;
                                $output .= $subItem->dump($indent, $times + 2, false);
                            } else {
                                $output .= '  ' . $subItem->dump($indent, $times + 1);
                            }
                        }
                    } else {
                        $output .= $item->dump($indent, $times + 1, false);
                    }
                }
            } else if ($this->isListOfTag($this->value)) {
                $output .= "\n";
                foreach ($this->value as $item) {
                    $output .= $item->dump($indent, $times + 1);
                }
            } else {
                $output .= " |\n";
                foreach ($this->value as $line) {
                    $output .= str_repeat(' ', ($times + 1) * $indent) . $line . "\n";
                }
            }
        } else {
            $output .= ' ' . $this->value;
        }

        return $output . "\n";
    }

    /**
     * Used by dump to know if the value need to be dumped as a list or not
     *
     * @param array $array
     * @return bool
     */
    private function isPartialList($array)
    {
        foreach ($array as $item) {
            if (is_array($item)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Used by dump to know if the value is a list of tags or a list of value
     *
     * @param array $array
     * @return bool
     */
    private function isListOfTag($array)
    {
        foreach ($array as $item) {
            if (!($item instanceof Tag)) {
                return false;
            }
        }

        return true;
    }

    // _.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-.

    /**
     * @param array $input
     * @return Tag|Tag[]|null
     * @throws InvalidArgumentException
     */
    public static function fromArray($input)
    {
        if (!is_array($input)) {
            throw new InvalidArgumentException('Input must be an array');
        }

        if (empty($input)) {
            return null;
        }

        if (count($input) == 1) {
            if (is_array(current($input))) {
                return new Tag(key($input), self::fromArray(current($input)));
            }
            return new Tag(key($input), current($input));
        }

        $tags = [];

        if (self::isList($input)) {
            foreach ($input as $item) {
                $tags[] = self::fromArray($item);
            }
        } else {
            foreach ($input as $key => $value) {
                if (is_array($value)) {
                    if (self::isValueList($value)) {
                        $tags[] = new Tag($key, $value);
                    } else {
                        $tags[] = new Tag($key, self::fromArray($value));
                    }
                } else {
                    $tags[] = new Tag($key, $value);
                }
            }
        }

        return $tags;
    }

    /**
     * @param array $array
     * @return bool
     */
    private static function isList($array)
    {
        foreach ($array as $item) {
            if (!is_array($item)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param array $array
     * @return bool
     */
    private static function isValueList($array)
    {
        $i = 0;
        foreach ($array as $key => $value) {
            if ($key !== $i || is_array($value)) {
                return false;
            }
            $i++;
        }

        return true;
    }
}