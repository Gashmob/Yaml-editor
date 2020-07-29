<?php


/**
 * Class NotYamlFileException
 * Throw if the file is not a .yml
 * @see YamlFile
 */
class NotYamlFileException extends Exception
{
    public function __construct()
    {
        parent::__construct('Le fichier n\'est pas un .yml');
    }
}