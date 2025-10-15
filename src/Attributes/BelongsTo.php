<?php


namespace Obuchmann\OdooJsonRpc\Attributes;

/**
 * @Annotation
 * @Target({"PROPERTY"})
 */
class BelongsTo
{
    /** @var string */
    public $name;
    
    /** @var string */
    public $class;

    /**
     * @param array $values
     */
    public function __construct($values)
    {
        if (is_array($values)) {
            $this->name = $values['name'] ?? null;
            $this->class = $values['class'] ?? null;
        } else {
            $this->name = $values;
        }
    }
}