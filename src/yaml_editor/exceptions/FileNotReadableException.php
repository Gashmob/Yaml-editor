<?php


namespace YamlEditor\Exceptions;


use Exception;

class FileNotReadableException extends Exception
{
    public function __construct()
    {
        parent::__construct("Le fichier ne peut être lu");
    }
}