<?php

namespace Gashmob\YamlEditor\Test\Parse3;

use Gashmob\YamlEditor\Tag;
use Gashmob\YamlEditor\Test\Test;
use Gashmob\YamlEditor\Yaml;

class Parse3Test implements Test
{
    /**
     * @inheritDoc
     */
    public function run()
    {
        $result = Yaml::parseFile(__DIR__ . '/test.yml');

        $tags = Tag::fromArray($result);

        if ((string)$tags[0] !== '{receipt: Oz-Ware Purchase Invoice}') {
            return false;
        }
        if ((string)$tags[1] != '{date: 2012-08-06}') {
            return false;
        }
        if ((string)$tags[2] !== '{customer: [{given: Dorothy}, {family: Gale}]}') {
            return false;
        }
        if ((string)$tags[3] !== '{items: [{0: [{0: {part_no: A4786}}, {1: {descrip: Water Bucket (Filled)}}, {2: {price: 1.47}}, {3: {quantity: 4}}]}, {1: [{0: {part_no: E1628}}, {1: {descrip: High Heeled "Ruby" Slippers}}, {2: {size: 8}}, {3: {price: 100.27}}, {4: {quantity: 1}}]}]}') {
            return false;
        }
        if ((string)$tags[4] !== '{bill-to: [{street: [{0:  123 Tornado Alley}, {1:  Suite 16}]}, {city: East Centerville}, {state: KS}]}') {
            return false;
        }
        if ((string)$tags[5] !== '{specialDelivery: Follow the Yellow Brick Road to the Emerald City. Pay no attention to the man behind the curtain.}') {
            return false;
        }

        return true;
    }
}