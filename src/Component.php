<?php

namespace Gashmob\YamlEditor;

use InvalidArgumentException;

class Component
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
        if ($this->value instanceof Component) {
            $v = $this->value->asArray();
        } else if (is_array($this->value)) {
            $v = [];
            foreach ($this->value as $item) {
                if ($item instanceof Component) {
                    $v[] = $item->asArray();
                } else {
                    $v[] = $item;
                }
            }
        }

        return [$this->tag => $v];
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return '';
    }

    /**
     * @param array $input
     * @return Component|Component[]
     * @throws InvalidArgumentException
     */
    public static function fromArray($input)
    {
        if (!is_array($input)) {
            throw new InvalidArgumentException('Input must be an array');
        }

        if (count($input) == 1) {
            if (is_array($input[key($input)])) {
                return new Component(key($input), self::fromArray($input[key($input)]));
            }
            return new Component(key($input), "");
        }

        $components = [];

        for ($i = 0; $i < count($input); $i++) {
            $components[] = self::fromArray($input[$i]);
        }

        return $components;
    }
}