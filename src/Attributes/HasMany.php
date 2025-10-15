<?php


namespace Obuchmann\OdooJsonRpc\Attributes;

/**
 * @Annotation
 * @Target({"PROPERTY"})
 */
class HasMany
{
    /** @var string */
    public $class;
    
    /** @var string|null */
    public $foreignKey;
    
    /** @var string|null */
    public $localKey;

    /**
     * @param array $values
     */
    public function __construct($values)
    {
        if (is_array($values)) {
            $this->class = $values['class'] ?? null;
            $this->foreignKey = $values['foreignKey'] ?? null;
            $this->localKey = $values['localKey'] ?? null;
        } else {
            $this->class = $values;
        }
    }
}