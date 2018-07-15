<?php

namespace Rogersxd\VCard;

/**
 * VCard Exception Class.
 */
class VCardException extends \Exception
{
    public static function elementExists($element)
    {
        return new self($element . '" not is multiple.');
    }

    public static function emptyURL()
    {
        return new self('Verify URL.');
    }

    public static function invalidImage()
    {
        return new self('Data is not an valid image.');
    }

    public static function outputDirectoryNotExists()
    {
        return new self('Output directory does not exist.');
    }
}
