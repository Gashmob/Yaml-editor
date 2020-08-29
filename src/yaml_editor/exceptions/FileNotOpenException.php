<?php


namespace YamlEditor\Exceptions;


use Exception;

class FileNotOpenException extends Exception
{

    /**
     * FileNotOpenException constructor.
     */
    public function __construct()
    {
        parent::__construct('Le fichier n\'est pas ouvert');
    }
}