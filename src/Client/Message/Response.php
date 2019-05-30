<?php

declare(strict_types=1);

namespace TrelloCycleTime\Client\Message;

use TrelloCycleTime\Exception\InvalidJsonException;

class Response
{
    public static function validate($jsonString)
    {
        $json = json_decode($jsonString, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidJsonException(json_last_error_msg(), json_last_error());
        }

        return $json;
    }
}