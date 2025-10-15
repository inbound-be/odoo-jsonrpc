<?php


namespace Obuchmann\OdooJsonRpc\Odoo\Request;

use Obuchmann\OdooJsonRpc\Exceptions\ConfigurationException;
use Obuchmann\OdooJsonRpc\Odoo\Endpoint\ObjectEndpoint;
use Obuchmann\OdooJsonRpc\Odoo\Request\Arguments\Domain;
use Obuchmann\OdooJsonRpc\Odoo\Request\Arguments\HasDomain;
use Obuchmann\OdooJsonRpc\Odoo\Request\Arguments\HasFields;
use Obuchmann\OdooJsonRpc\Odoo\Request\Arguments\HasGroupBy;
use Obuchmann\OdooJsonRpc\Odoo\Request\Arguments\HasLimit;
use Obuchmann\OdooJsonRpc\Odoo\Request\Arguments\HasOffset;
use Obuchmann\OdooJsonRpc\Odoo\Request\Arguments\HasOptions;
use Obuchmann\OdooJsonRpc\Odoo\Request\Arguments\HasOrder;
use Obuchmann\OdooJsonRpc\Odoo\Request\Arguments\Options;

class RequestBuilder
{
    use HasDomain, HasOrder, HasOffset, HasLimit, HasFields, HasOptions, HasGroupBy;

    /** @var ObjectEndpoint */
    protected $endpoint;
    
    /** @var string */
    protected $model;

    public function __construct(
        ObjectEndpoint $endpoint,
        string $model,
        Domain $domain,
        ?Options $options = null
    )
    {
        $this->endpoint = $endpoint;
        $this->model = $model;
        $this->domain = $domain;
        $this->options = $options ?? new Options();
    }

    public function can(string $permission): bool
    {
        return $this->endpoint->checkAccessRights($this->model, $permission, $this->options);
    }

    /**
     * @return array
     */
    public function get()
    {
        if($this->hasGroupBy()){
            return $this->endpoint->readGroup(
                $this->model,
                $this->groupBy,
                $this->domain,
                $this->fields,
                $this->offset,
                $this->limit,
                $this->getOrderString(),
                $this->options
            );
        }
        return $this->endpoint->searchRead(
            $this->model,
            $this->domain,
            $this->fields,
            $this->offset,
            $this->limit,
            $this->getOrderString(),
            $this->options
        );
    }

    /**
     * @return object|array|null
     */
    public function first()
    {
        $this->limit = 1;
        $result = $this->get();
        return $result[0] ?? null;
    }

    /**
     * @return array
     */
    /**
     * @return array
     */
    /**
     * @return array
     */
    public function ids()
    {
        $result = $this->endpoint->searchRead(
            $this->model,
            $this->domain,
            ['id'],
            $this->offset,
            $this->limit,
            $this->getOrderString(),
            $this->options
        );
        
        return array_map(function($item) {
            return $item['id'];
        }, $result);
    }

    /**
     * @return int
     */
    public function count()
    {
        return $this->endpoint->count(
            $this->model,
            $this->domain,
            $this->offset,
            $this->limit,
            $this->getOrderString(),
            $this->options
        );
    }

    /**
     * @return bool
     */
    public function delete()
    {
        $ids = $this->ids();
        return $this->endpoint->unlink($this->model, $ids, $this->options);
    }

    /**
     * @param array $values
     * @return bool|int
     */
    public function create(array $values)
    {
        return $this->endpoint->create($this->model, $values, $this->options);
    }

    /**
     * @param array $values
     * @return bool
     */
    public function write(array $values)
    {
        $ids = $this->ids();
        return $this->endpoint->write($this->model, $ids, $values, $this->options);
    }

    /**
     * @param array $values
     * @return bool
     */
    public function update(array $values)
    {
        return $this->write($values);
    }

}