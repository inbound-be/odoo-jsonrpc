<?php


namespace Obuchmann\OdooJsonRpc\Odoo\Request;

/**
 * Class CheckAccessRights
 *
 * Checks permissions
 * @package Obuchmann\OdooJsonRpc\Odoo\Request
 */
class CheckAccessRights extends Request
{
    /** @var string */
    protected $permission;

    /**
     * CheckAccessRights constructor.
     * @param string $model
     * @param string $permission
     */
    public function __construct(
        string $model,
        string $permission
    )
    {
        parent::__construct($model, 'check_access_rights');
        $this->permission = $permission;
    }


    public function toArray(): array
    {
        return [
            $this->permission
        ];
    }
}