<?php


namespace Obuchmann\OdooJsonRpc\Odoo\Request;

class Read extends Request
{
    /** @var int[] */
    protected $ids;
    
    /** @var string[] */
    protected $fields;

    /**
     * Read constructor.
     * @param string $model
     * @param int[] $ids
     * @param string[] $fields
     */
    public function __construct(
        string $model,
        array $ids,
        array $fields = []
    )
    {
        parent::__construct($model, 'read');
        $this->ids = $ids;
        $this->fields = $fields;
    }

    public function toArray(): array
    {
        return [
            $this->ids, $this->fields
        ];
    }
}