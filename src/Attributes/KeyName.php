<?php


namespace Obuchmann\OdooJsonRpc\Attributes;

/**
 * @Annotation
 * @Target({"CLASS"})
 */
class KeyName implements OdooAttribute
{
    /** @var string */
    public $name;

    /**
     * @param array $values
     */
    public function __construct($values)
    {
        $this->name = is_array($values) ? $values['value'] : $values;
    }
}