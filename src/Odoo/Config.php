<?php

namespace Obuchmann\OdooJsonRpc\Odoo;

class Config
{
    /** @var string */
    protected $database;
    
    /** @var string */
    protected $host;
    
    /** @var string */
    protected $username;
    
    /** @var string */
    protected $password;
    
    /** @var bool */
    protected $sslVerify;
    
    /** @var int|null */
    protected $fixedUserId;

    public function __construct(
        string $database,
        string $host,
        string $username,
        string $password,
        bool $sslVerify = true,
        ?int $fixedUserId = null
    ) {
        $this->database = $database;
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->sslVerify = $sslVerify;
        $this->fixedUserId = $fixedUserId;
    }

    /**
     * @return string
     */
    public function getDatabase(): string
    {
        return $this->database;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return boolean
     */
    public function getSslVerify(): bool
    {
        return $this->sslVerify;
    }

    public function getFixedUserId(): ?int
    {
        return $this->fixedUserId;
    }
}
