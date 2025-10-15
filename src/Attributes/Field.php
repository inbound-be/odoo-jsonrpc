<?php


namespace Obuchmann\OdooJsonRpc\Attributes;

/**
 * @Annotation
 * @Target({"PROPERTY"})
 */
class Field implements OdooAttribute
{
    /** @var string|null */
    public $name;

    /**
     * @param array $values
     */
    public function __construct($values = [])
    {
        if (is_array($values)) {
            $this->name = $values['value'] ?? $values['name'] ?? null;
        } else {
            $this->name = $values;
        }
    }
}