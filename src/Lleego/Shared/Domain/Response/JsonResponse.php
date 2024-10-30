<?php

namespace App\Lleego\Shared\Domain\Response;

use Exception;

class JsonResponse
{
    /**
     * @param mixed $object
     */
    public static function convertObjectToArray($object)
    {
        if ($object === null) {
            throw new Exception('Cannot convert object to array');
        } elseif(is_array($object)) {
            $output = [];

            foreach ($object as $singleObject) {
                $output[] = self::getArray($singleObject);
            }

            return $output;
        } else {
            return self::getArray($object);
        }
    }

    private static function getArray($object)
    {
        if (!method_exists($object, 'toArray')) {
            throw new Exception('Cannot convert object to array');
        }

        return $object->toArray();
    }
}