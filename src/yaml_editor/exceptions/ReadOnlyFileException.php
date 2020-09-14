<?php


namespace YamlEditor\Exceptions;


use Exception;

/**
 * Class ReadOnlyFileException
 * Throw if we try to modify a read-only file
 * @package YamlEditor\Exceptions
 */
class ReadOnlyFileException extends Exception
{
    public function __construct()
    {
        parent::__construct("Le fichier est en lecture seule");
    }
}