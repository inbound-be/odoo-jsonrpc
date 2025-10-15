<?php


namespace Obuchmann\OdooJsonRpc\Attributes;

/**
 * @Annotation
 * @Target({"CLASS"})
 */
class Model implements OdooAttribute
{
    /** @var string */
    public $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }
}