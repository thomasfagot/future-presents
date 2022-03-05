<?php

namespace App\Services\Serializer;

class CircularReferenceHandler
{
    public function __invoke($object): string
    {
        return $object->getId();
    }
}