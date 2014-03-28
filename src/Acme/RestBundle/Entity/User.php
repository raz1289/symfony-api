<?php

namespace Acme\RestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * Acme\RestBundle\Entity\User
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Acme\RestBundle\Entity\UserRepository")
 *
 * @ExclusionPolicy("all")
 */
class User
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Expose
     */
    private $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     *
     * @Constraints\NotNull
     * @Constraints\NotBlank
     * @Expose
     */
    private $name;

    /**
     * @var Organization $organization
     *
     * @ORM\ManyToOne(targetEntity="Organization", inversedBy="users")
     */
    private $organization;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set organization
     *
     * @param Acme\RestBundle\Entity\Organization $organization
     * @return User
     */
    public function setOrganization(\Acme\RestBundle\Entity\Organization $organization = null)
    {
        $this->organization = $organization;

        return $this;
    }

    /**
     * Get organization
     *
     * @return Acme\RestBundle\Entity\Organization 
     */
    public function getOrganization()
    {
        return $this->organization;
    }
}