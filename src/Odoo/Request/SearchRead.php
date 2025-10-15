<?php


namespace Obuchmann\OdooJsonRpc\Odoo\Request;
use Obuchmann\OdooJsonRpc\Odoo\Request\Arguments\Domain;

/**
 * Class SearchRead
 *
 * Searches for models and returns values
 * @package Obuchmann\OdooJsonRpc\Odoo\Request
 */
class SearchRead extends Request
{
    /** @var Domain */
    protected $domain;
    
    /** @var array|null */
    protected $fields;
    
    /** @var int */
    protected $offset = 0;
    
    /** @var int|null */
    protected $limit;
    
    /** @var string|null */
    protected $order;

    /**
     * SearchRead constructor.
     * @param string $model
     * @param Domain $domain
     * @param array|null $fields
     * @param int $offset
     * @param int|null $limit
     * @param string|null $order
     */
    public function __construct(
        string $model,
        Domain $domain,
        ?array $fields = null,
        int $offset = 0,
        ?int $limit = null,
        ?string $order = null
    )
    {
        parent::__construct($model, 'search_read');
        $this->domain = $domain;
        $this->fields = $fields;
        $this->offset = $offset;
        $this->limit = $limit;
        $this->order = $order;
    }

    public function toArray(): array
    {
        return [
            $this->domain->toArray(),
            $this->fields,
            $this->offset,
            $this->limit,
            $this->order
        ];
    }
}