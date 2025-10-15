<?php


namespace Obuchmann\OdooJsonRpc\Attributes;

/**
 * @Annotation
 * @Target({"PROPERTY"})
 */
class Key implements OdooAttribute
{
    public function __construct()
    {
    }
}