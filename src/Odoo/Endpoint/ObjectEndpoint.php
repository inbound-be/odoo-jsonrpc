<?php


namespace Obuchmann\OdooJsonRpc\Odoo\Endpoint;


use Obuchmann\OdooJsonRpc\Odoo\Config;
use Obuchmann\OdooJsonRpc\Odoo\Context;
use Obuchmann\OdooJsonRpc\Odoo\Request\Arguments\Domain;
use Obuchmann\OdooJsonRpc\Odoo\Request\Arguments\Options;
use Obuchmann\OdooJsonRpc\Odoo\Request\CheckAccessRights;
use Obuchmann\OdooJsonRpc\Odoo\Request\Create;
use Obuchmann\OdooJsonRpc\Odoo\Request\FieldsGet;
use Obuchmann\OdooJsonRpc\Odoo\Request\Read;
use Obuchmann\OdooJsonRpc\Odoo\Request\ReadGroup;
use Obuchmann\OdooJsonRpc\Odoo\Request\Request;
use Obuchmann\OdooJsonRpc\Odoo\Request\RequestBuilder;
use Obuchmann\OdooJsonRpc\Odoo\Request\Search;
use Obuchmann\OdooJsonRpc\Odoo\Request\SearchRead;
use Obuchmann\OdooJsonRpc\Odoo\Request\Unlink;
use Obuchmann\OdooJsonRpc\Odoo\Request\Write;

class ObjectEndpoint extends Endpoint
{
    /** @var string */
    protected $service = 'object';
    
    /** @var Context */
    protected $context;
    
    /** @var int */
    protected $uid;

    /**
     * ObjectEndpoint constructor.
     * @param Config $config
     * @param Context $context
     * @param int $uid
     */
    public function __construct(Config $config, Context $context, int $uid)
    {
        parent::__construct($config);
        $this->context = $context;
        $this->uid = $uid;
    }

    /**
     * @param Context $context
     */
    public function setContext(Context $context): void
    {
        $this->context = $context;
    }


    /**
     * @param Request $request
     * @param Options|null $options
     * @return mixed
     */
    public function execute(Request $request, $options = null)
    {
        if ($options === null) {
            $options = new Options();
        }

        $value = $request->execute(
            $this->getClient(),
            $this->getConfig()->getDatabase(),
            $this->uid,
            $this->getConfig()->getPassword(),
            $options->withContext($this->context)
        );
        return $value;
    }

    /**
     * @param string $model
     * @param Domain|null $domain
     * @return RequestBuilder
     */
    public function model($model, $domain = null)
    {
        if ($domain === null) {
            $domain = new Domain();
        }
        
        return new RequestBuilder(
            $this,
            $model,
            $domain
        );
    }

    /**
     * @param string $model
     * @param string $permission
     * @param Options|null $options
     * @return bool
     */
    public function checkAccessRights($model, $permission, $options = null)
    {
        return $this->execute(new CheckAccessRights(
            $model,
            $permission
        ), $options);
    }

    /**
     * @param string $model
     * @param Domain|null $domain
     * @param int $offset
     * @param int|null $limit
     * @param string|null $order
     * @param Options|null $options
     * @return int
     */
    /**
     * @param string $model
     * @param Domain|null $domain
     * @param int $offset
     * @param int|null $limit
     * @param string|null $order
     * @param Options|null $options
     * @return int
     */
    public function count($model, $domain = null, $offset = 0, $limit = null, $order = null, $options = null)
    {
        if ($domain === null) {
            $domain = new Domain();
        }
        
        return $this->execute(new \Obuchmann\OdooJsonRpc\Odoo\Request\SearchCount(
            $model,
            $domain
        ), $options);
    }

    /**
     * @param string $model
     * @param array $ids
     * @param array $fields
     * @param Options|null $options
     * @return array
     */
    public function read($model, array $ids, array $fields = [], $options = null)
    {
        return $this->execute(new Read(
            $model,
            $ids,
            $fields
        ), $options);
    }


    /**
     * @param string $model
     * @param Domain|null $domain
     * @param array|null $fields
     * @param int $offset
     * @param int|null $limit
     * @param string|null $order
     * @param Options|null $options
     * @return array
     */
    public function searchRead($model, $domain = null, $fields = null, $offset = 0, $limit = null, $order = null, $options = null)
    {
        if ($domain === null) {
            $domain = new Domain();
        }
        
        return $this->execute(new SearchRead(
            $model,
            $domain,
            $fields,
            $offset,
            $limit,
            $order
        ), $options);
    }

    /**
     * @param string $model
     * @param array $groupBy
     * @param Domain|null $domain
     * @param array|null $fields
     * @param int $offset
     * @param int|null $limit
     * @param string|null $order
     * @param Options|null $options
     * @return array
     */
    public function readGroup($model, array $groupBy, $domain = null, $fields = null, $offset = 0, $limit = null, $order = null, $options = null)
    {
        return $this->execute(new ReadGroup(
            $model,
            $groupBy,
            $domain,
            $fields,
            $offset,
            $limit,
            $order
        ), $options);
    }

    /**
     * @param string $model
     * @param array|null $fields
     * @param array|null $attributes
     * @param Options|null $options
     * @return object
     */
    public function fieldsGet($model, $fields = null, $attributes = null, $options = null)
    {
        return $this->execute(new FieldsGet(
            $model,
            $fields,
            $attributes
        ), $options);
    }


    /**
     * @param string $model
     * @param array $ids
     * @param Options|null $options
     * @return bool
     */
    public function unlink($model, array $ids, $options = null)
    {
        return $this->execute(new Unlink(
            $model,
            $ids
        ), $options);
    }

    /**
     * @param string $model
     * @param array $ids
     * @param array $values
     * @param Options|null $options
     * @return bool
     */
    public function write($model, array $ids, array $values, $options = null)
    {
        return $this->execute(new Write(
            $model,
            $ids,
            $values
        ), $options);
    }
    
    /**
     * @param string $model
     * @param array $values
     * @param Options|null $options
     * @return int|bool
     */
    public function create($model, array $values, $options = null)
    {
        return $this->execute(new Create(
            $model,
            $values
        ), $options);
    }
}