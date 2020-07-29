Yaml Editor
===

Cette série de 3 classes vous permettra de lire et de modifier facilement vos fichiers yaml.

___

Tutoriel
---
Voici un petit exemple de comment utiliser ces classes :
````php
// Ouvre un fichier yaml, le créé si il n'existe pas
$yamlFile = new YamlFile('monFichier.yml');
// Convertie le tableau yaml en tableau php
$yamlArray = new YamlArray($yamlFile);

// Modifie la valeur de foo.bar à 2, créé le chemin si il n'existe pas
$yamlArray->set('foo.bar', 2);
// Affiche la valeur de foo.bar, donc 2
echo $yamlArray->get('foo.bar');

// Modifie le fichier qu'on a ouvert avec le nouveau tableau
$yamlFile->setYamlArray($yamlArray);
````