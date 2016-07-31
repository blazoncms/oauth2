<?php

namespace BlazonCms\OAuth2\Entity;

use BlazonCms\Core\Entity\TimestampableTrait;
use Doctrine\ORM\Mapping as ORM;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\Traits\ClientTrait;

/**
 * Doctrine Entity for Access Tokens
 *
 * @ORM\Entity
 * @ORM\Table(name="oauth_clients")
 * @ORM\Entity(repositoryClass="BlazonCms\OAuth2\ClientRepository")
 */
class Client implements ClientEntityInterface
{
    use TimestampableTrait;

    use ClientTrait;

    /**
     * @var string Client ID
     *
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", options={"default" = 0})
     */
    protected $trusted = false;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $redirectUri;
    
    public function getIdentifier() : string 
    {
        return $this->id;
    }
    
    public function setIdentifier(string $id)
    {
        $this->id = $id;
    }

    public function getName() : string 
    {
        return $this->name;
    }
    
    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getRedirectUri() : string
    {
        $this->redirectUri;
    }
    
    public function setRedirectUri(string $uri)
    {
        $this->redirectUri = $uri;
    }
    
    public function isTrusted() : bool 
    {
        return $this->trusted;
    }

    public function setTrusted(bool $trusted)
    {
        $this->trusted = $trusted;
    }
}
