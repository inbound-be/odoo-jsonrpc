<?php


namespace Obuchmann\OdooJsonRpc\Odoo\Request\Arguments;


use Obuchmann\OdooJsonRpc\Odoo\Context;

class Options
{
    /** @var array */
    protected $options = [];
    
    /** @var Context|null */
    protected $context;
    
    public function __construct(array $options = [], ?Context $context = null)
    {
        $this->options = $options;
        $this->context = $context;
    }

    public function toArray(): array
    {
        $context = $this->context->toArray();
        if(empty($context)){
            return $this->options;
        }
        return ['context' => $context] + $this->options;
    }

    /**
     * @param Context $context
     * @return $this
     */
    public function withContext(Context $context)
    {
        $this->context = $context->setDefaults($this->context);
        return $this;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function setRaw(string $key, $value)
    {
        $this->options[$key] = $value;
        return $this;
    }

    /**
     * @param int $value
     * @return $this
     */
    public function limit(int $value)
    {
        return $this->setRaw('limit', $value);
    }

    /**
     * @param int $value
     * @return $this
     */
    public function offset(int $value)
    {
        return $this->setRaw('offset', $value);
    }
}
