<?php


namespace Obuchmann\OdooJsonRpc\Odoo\Endpoint;


use Obuchmann\OdooJsonRpc\Exceptions\AuthenticationException;
use Obuchmann\OdooJsonRpc\Odoo\Models\Version;

class CommonEndpoint extends Endpoint
{
    /** @var string */
    protected $service = 'common';

    /**
     * @return int
     * @throws AuthenticationException
     */
    public function authenticate()
    {
        $fixedUid = $this->getConfig()->getFixedUserId();
        if ($fixedUid !== null && $fixedUid > 0) {
            return $fixedUid;
        }

        $client = $this->getClient(true);
        $uid = $client
            ->authenticate(
                $this->getConfig()->getDatabase(),
                $this->getConfig()->getUsername(),
                $this->getConfig()->getPassword(),
                ['empty' => 'false']
            );
        if ($uid > 0) {
            return $uid;
        }

        throw new AuthenticationException($client->lastResponse(), "Authentication failed!");
    }


    /**
     * @return Version
     */
    public function version()
    {
        return Version::hydrate(
            $this->getClient()
                ->version()
        );
    }
}