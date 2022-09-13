<?php

namespace Gashmob\YamlEditor\exceptions;

use Exception;

class InvalidYamlException extends Exception
{
    public function __construct($line_num, $line, $message = "")
    {
        $message = "Invalid YAML at line $line_num: $line" . ($message ? " ($message)" : "");
        parent::__construct($message);
    }
}