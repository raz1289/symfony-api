<?php

namespace Acme\RestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Organization
 */
class Organization
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;


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
     * @return Organization
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
     * @ORM\OneToMany(targetEntity="User", mappedBy="organization)
     *
     * @var Doctrine\Common\Collections\Collection $users
     */
    private $users;
}
