<?php

namespace BlazonCms\OAuth2\Repository;

use BlazonCms\OAuth2\Entity\AccessToken;
use Doctrine\ORM\EntityRepository;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;

class AccessTokenRepository extends EntityRepository implements AccessTokenRepositoryInterface
{
    public function getNewToken(
        ClientEntityInterface $clientEntity,
        array $scopes,
        $userIdentifier = null
    ) {
        $accessToken = new AccessToken();
        $accessToken->setClient($clientEntity);

        foreach ($scopes as $scope) {
            $accessToken->addScope($scope);
        }

        $accessToken->setUserIdentifier($userIdentifier);
        return $accessToken;
    }

    public function persistNewAccessToken(
        AccessTokenEntityInterface $accessTokenEntity
    ) {
        $this->_em->persist($accessTokenEntity);
        $this->_em->flush($accessTokenEntity);
    }

    public function revokeAccessToken($tokenId)
    {
        $this->_em->remove(
            $this->_em->getReference($this->getEntityName(), $tokenId)
        );
    }

    public function isAccessTokenRevoked($tokenId)
    {
        $find = $this->find($tokenId);
        return $find ? true : false;
    }
}
