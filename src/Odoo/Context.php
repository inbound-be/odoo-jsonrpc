<?php

namespace Obuchmann\OdooJsonRpc\Odoo;

class Context
{
    /** @var string|null */
    protected $lang;
    
    /** @var string|null */
    protected $timezone;
    
    /** @var int|null */
    protected $companyId;
    
    /** @var array */
    protected $contextArgs;

    /**
     * Context constructor.
     * @param string|null $lang
     * @param string|null $timezone
     * @param int|null $companyId
     * @param array $contextArgs
     */
    public function __construct(
        ?string $lang = null,
        ?string $timezone = null,
        ?int $companyId = null,
        array $contextArgs = []
    ) {
        $this->lang = $lang;
        $this->timezone = $timezone;
        $this->companyId = $companyId;
        $this->contextArgs = $contextArgs;
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function setContextArg($key, $value)
    {
        $this->contextArgs[$key] = $value;
    }


    /**
     * @return array
     */
    public function toArray()
    {
        return array_filter(array_merge([
            'lang' => $this->lang,
            'tz' => $this->timezone,
            'company_id' => $this->companyId
        ], $this->contextArgs));
    }

    /**
     * @return self
     */
    public function clone()
    {
        return clone $this;
    }


    /**
     * @param Context|null $context
     * @return $this
     */
    public function setDefaults($context)
    {
        if($context){
            $this->lang = $this->lang ?? $context->lang;
            $this->timezone = $this->timezone ?? $context->timezone;
            $this->companyId = $this->companyId ?? $context->companyId;
            
            // Merge contextArgs, keeping existing values
            foreach ($context->contextArgs as $key => $value) {
                if (!array_key_exists($key, $this->contextArgs)) {
                    $this->setContextArg($key, $value);
                }
            }
        }
        
        return $this;
    }

}