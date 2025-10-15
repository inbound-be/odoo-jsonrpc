<?php


namespace Obuchmann\OdooJsonRpc\Odoo\Request;


/**
 * Class Create
 *
 * Creates a new model instance
 * @package Obuchmann\OdooJsonRpc\Odoo\Request
 */
class Create extends Request
{
    /** @var array */
    protected $values;

    /**
     * Create constructor.
     * @param string $model
     * @param int[] $values
     */
    public function __construct(
        string $model,
        array $values
    )
    {
        parent::__construct($model, 'create');
        $this->values = $values;
    }

    public function toArray(): array
    {
        return [
            $this->values
        ];
    }

}