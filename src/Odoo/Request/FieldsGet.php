<?php


namespace Obuchmann\OdooJsonRpc\Odoo\Request;

/**
 * Class FieldsGet
 *
 * Returns model fields description
 * @package Obuchmann\OdooJsonRpc\Odoo\Request
 */
class FieldsGet extends Request
{
    /** @var array|null */
    protected $fields;
    
    /** @var array|null */
    protected $attributes;

    /**
     * FieldsGet constructor.
     * @param string $model
     * @param array|null $fields
     * @param array|null $attributes
     */
    public function __construct(
        string $model,
        ?array $fields,
        ?array $attributes
    )
    {
        parent::__construct($model, 'fields_get');
        $this->fields = $fields;
        $this->attributes = $attributes;
    }

    public function toArray(): array
    {
        return [
            $this->fields,
            $this->attributes
        ];
    }
}