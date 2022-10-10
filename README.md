# Yaml Editor

[![Tests](https://github.com/Gashmob/Yaml-editor/actions/workflows/test.yml/badge.svg)](https://github.com/Gashmob/Yaml-editor/actions/workflows/test.yml)

The `Yaml` class allow you to read and write YAML files easily.

___

## Tutorial

Here a little example of how to use this classes:

```php
<?php

use Gashmob\YamlEditor\Yaml;

// Parse a file:
$output = Yaml::parseFile('myFile.yml');

// Or just parse directly a string
$output = Yaml::parse('foo: bar');

// Then get the yaml result from the output
$yaml = Yaml::dump($output);
file_put_contents('myFile.yml', $yaml);
```