<?php

namespace BlazonCms\OAuth2\Entity;

use BlazonCms\Core\Entity\TimestampableTrait;
use Doctrine\ORM\Mapping as ORM;
use League\OAuth2\Server\Entities\ScopeEntityInterface;

/**
 * Doctrine Entity for Access Tokens
 *
 * @ORM\Entity
 * @ORM\Table(name="oauth_scopes")
 */
class Scope implements ScopeEntityInterface
{
    use TimestampableTrait;

    /**
     * @var string Client ID
     *
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    protected $id;

    public function getIdentifier() : string
    {
        return $this->id;
    }
    
    public function setIdentifier(string $id)
    {
        $this->id = $id;
    }

    function jsonSerialize()
    {
        return [$this->getIdentifier()];
    }


}
