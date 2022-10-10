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
        if ((string)$tags[3] !== '{items: [[{part_no: A4786}, {descrip: Water Bucket (Filled)}, {price: 1.47}, {quantity: 4}], [{part_no: E1628}, {descrip: High Heeled "Ruby" Slippers}, {size: 8}, {price: 100.27}, {quantity: 1}], {foo: bar}]}') {
            return false;
        }
        if ((string)$tags[4] !== '{bill-to: [{street: [123 Tornado Alley, Suite 16]}, {city: East Centerville}, {state: KS}]}') {
            return false;
        }
        if ((string)$tags[5] !== '{specialDelivery: Follow the Yellow Brick Road to the Emerald City. Pay no attention to the man behind the curtain.}') {
            return false;
        }

        return true;
    }
}