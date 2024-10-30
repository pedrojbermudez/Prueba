<?php

namespace App\Lleego\Shared\Domain\Xml;

use SimpleXMLElement;

class Xml
{
    public static function convertFromStringXmlToArray(string $xmlData): array
    {
        $xmlDataObject = self::loadXmlFromString($xmlData);
        $json = json_encode($xmlDataObject);

        return json_decode($json, true);
    }

    public static function loadXmlFromString(string $xmlData): SimpleXMLElement
    {
        return new SimpleXMLElement($xmlData);
    }
}