<?php

namespace BlazonCms\OAuth2\Entity;

use BlazonCms\Core\Entity\TimestampableTrait;
use BlazonCms\Core\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectManagerAware;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Entities\Traits\AccessTokenTrait;

/**
 * Doctrine Entity for Access Tokens
 *
 * @ORM\Entity
 * @ORM\Table(name="oauth_access_token")
 * @ORM\Entity(repositoryClass="BlazonCms\OAuth2\AccessTokenRepository")
 */
class AccessToken implements AccessTokenEntityInterface, ObjectManagerAware
{
    use TimestampableTrait;

    /**
     * @var int Auto-Incremented Primary Key
     *
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    protected $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    protected $expires;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="BlazonCms\Core\Entity\User")
     * @ORM\JoinColumn(
     *      name="user_id",
     *      referencedColumnName="id",
     *      onDelete="CASCADE"
     * )
     */
    protected $user;

    /**
     * @var Client
     *
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumn(
     *      name="client_id",
     *      referencedColumnName="id",
     *      onDelete="CASCADE"
     * )
     */
    protected $client;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Scope")
     * @ORM\JoinTable(
     *     name="oauth_access_token_scopes",
     *     joinColumns={
     *         @ORM\JoinColumn(
     *             name="access_token_id",
     *             referencedColumnName="id",
     *             onDelete="CASCADE"
     *         )
     *     },
     *     inverseJoinColumns={
     *         @ORM\JoinColumn(
     *             name="scope_id",
     *             referencedColumnName="id",
     *             onDelete="CASCADE"
     *         )
     *     }
     * )
     */
    protected $scopes;

    /**
     * @var EntityManagerInterface Not what I wanted, but needed per the interface
     */
    protected $entityManager;

    use AccessTokenTrait;

    public function __construct()
    {
        $this->scopes = new ArrayCollection();
    }

    public function getIdentifier() : string
    {
        return $this->id;
    }

    public function setIdentifier($identifier)
    {
        $this->id = $identifier;
    }

    public function getExpiryDateTime() : \DateTime
    {
        return $this->expires;
    }

    public function setExpiryDateTime(\DateTime $dateTime)
    {
        $this->expires = $dateTime;
    }

    public function setUserIdentifier($identifier)
    {
        $this->user = $this->entityManager->getReference(
            'BlazonCms\Core\Entity\User',
            $identifier
        );
    }

    public function getUserIdentifier() : string
    {
        return $this->user->getId();
    }

    public function getClient() : Client
    {
        return $this->client;
    }

    public function setClient(ClientEntityInterface $client)
    {
        $this->client = $client;
    }

    public function addScope(ScopeEntityInterface $scope)
    {
        $this->scopes->add($scope);
    }

    public function getScopes() : ArrayCollection
    {
        return $this->scopes;
    }

    public function isExpired()
    {
        $now = new \DateTime();

        if ($now > $this->getExpiryDateTime()) {
            return true;
        }

        return false;
    }

    public function injectObjectManager(
        ObjectManager $objectManager,
        ClassMetadata $classMetadata
    ) {
        $this->entityManager = $objectManager;
    }
}
