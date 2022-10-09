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

        $components = [];

        if (self::isList($input)) {
            foreach ($input as $item) {
                $components[] = self::fromArray($item);
            }
        } else {
            foreach ($input as $key => $value) {
                if (is_array($value)) {
                    $components[] = new Tag($key, self::fromArray($value));
                } else {
                    $components[] = new Tag($key, $value);
                }
            }
        }

        return $components;
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
}