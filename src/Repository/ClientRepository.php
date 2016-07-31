<?php

namespace BlazonCms\OAuth2\Repository;

use BlazonCms\OAuth2\Entity\Client;
use Doctrine\ORM\EntityRepository;
use League\OAuth2\Server\Repositories\ClientRepositoryInterface;

class ClientRepository extends EntityRepository implements ClientRepositoryInterface
{
    public function getClientEntity(
        $clientIdentifier,
        $grantType,
        $clientSecret = null,
        $mustValidateSecret = true
    ) {
        /** @var Client $client */
        $client = $this->find($clientIdentifier);

        if (!$client) {
            return;
        }

        if ($mustValidateSecret === true
            && !$client->isTrusted()
            && password_verify($clientSecret, $clients[$clientIdentifier]['secret']) === false
        ) {
            return;
        }
    }

}
