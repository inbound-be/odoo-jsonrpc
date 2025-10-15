<?php


namespace Obuchmann\OdooJsonRpc\Odoo\Request;

class Unlink extends Request
{
    /** @var int[] */
    protected $ids;

    /**
     * Unlink constructor.
     * @param string $model
     * @param int[] $ids
     */
    public function __construct(
        string $model,
        array $ids
    )
    {
        parent::__construct($model, 'unlink');
        $this->ids = $ids;
    }

    public function toArray(): array
    {
        return [
            $this->ids
        ];
    }

}