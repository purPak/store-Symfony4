<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as FOSParentUser;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="app_user")
 */
class User extends FOSParentUser
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\IdentityUser", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $identity;

    public function getIdentity(): ?IdentityUser
    {
        return $this->identity;
    }

    public function setIdentity(IdentityUser $identity): self
    {
        $this->identity = $identity;

        return $this;
    }

    /**

     * @param string $userRole
     */
    public function setRole(string $userRole)
    {
        // Drop tous les rôles 
        foreach ($this->getRoles() as $role) {
            $this->removeRole($role);
        }
        // Ajoute le rôle unique passé en paramètre
        $this->addRole($userRole);
    }

}
