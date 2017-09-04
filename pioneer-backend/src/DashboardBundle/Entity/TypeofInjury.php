<?php

namespace DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TypeofInjury
 *
 * @ORM\Table(name="typeof_injury")
 * @ORM\Entity(repositoryClass="DashboardBundle\Repository\TypeofInjuryRepository")
 */
class TypeofInjury
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var string
     *
     * @ORM\Column(name="injuryName", type="string", length=255)
     */
    private $injuryName;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getInjuryName()
    {
        return $this->injuryName;
    }

    /**
     * @param string $injuryName
     */
    public function setInjuryName($injuryName)
    {
        $this->injuryName = $injuryName;
    }

}

