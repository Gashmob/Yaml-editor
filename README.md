# Yaml Editor

This classes allow you to read and write YAML files easily.

___

## Tutorial

Here a little example of how to use this classes:

````php
use YamlEditor\YamlFile;

// Open a yaml file, create it if it doesn't exist
$yamlFile = new YamlFile('myFile.yml');
// Convert yaml array to php array
$yamlArray = $yamlFile->getYamlArray();

// Modify value foo.bar to 2, create the path if it doesn't exist
$yamlArray->set('foo.bar', 2);
// Show the value of foo.bar, so 2
echo $yamlArray->get('foo.bar');

// Modify the opened file with the new array
$yamlFile->setYamlArray($yamlArray);
````