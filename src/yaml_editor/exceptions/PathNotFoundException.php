<?php

namespace YamlEditor\Exceptions;

use Exception;

/**
 * Class PathNotFoundException
 * Throw if the path is not found in the array
 * @see YamlArray
 */
class PathNotFoundException extends Exception
{
    public function __construct()
    {
        parent::__construct('Le chemin demandé n\'existe pas');
    }
}