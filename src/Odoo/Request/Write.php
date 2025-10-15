<?php


namespace Obuchmann\OdooJsonRpc\Odoo\Request;

class Write extends Request
{
    /** @var int[] */
    protected $ids;
    
    /** @var array */
    protected $values;

    /**
     * Write constructor.
     * @param string $model
     * @param int[] $ids
     * @param array $values
     */
    public function __construct(
        string $model,
        array $ids,
        array $values
    )
    {
        parent::__construct($model, 'write');
        $this->ids = $ids;
        $this->values = $values;
    }

    public function toArray(): array
    {
        return [
            $this->ids, $this->values
        ];
    }

}