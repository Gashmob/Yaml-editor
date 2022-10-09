<?php

namespace Gashmob\YamlEditor\Test\Parse4;

use Gashmob\YamlEditor\Tag;
use Gashmob\YamlEditor\Test\Test;
use Gashmob\YamlEditor\Yaml;

class Parse4Test implements Test
{

    /**
     * @inheritDoc
     */
    public function run()
    {
        $result = Yaml::parse('');

        $tag = Tag::fromArray($result);

        return empty($result) && $tag == null;
    }
}