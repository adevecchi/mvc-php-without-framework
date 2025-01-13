<?php

namespace Application\Helpers;

final class Json
{
    private function __construct() { }

    public static function encode($data, bool $pretty = false) : string
    {
        return $pretty ? json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
                       : json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    public static function decode(string $data, bool $assoc = false) : object
    {
        return json_decode($data, $assoc);
    }
}
