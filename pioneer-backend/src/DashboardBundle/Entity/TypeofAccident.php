<?php

namespace DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TypeofAccident
 *
 * @ORM\Table(name="typeof_accident")
 * @ORM\Entity(repositoryClass="DashboardBundle\Repository\TypeofAccidentRepository")
 */
class TypeofAccident
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
     * @ORM\Column(name="accidentName", type="string", length=255)
     */
    private $accidentName;


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
    public function getAccidentName()
    {
        return $this->accidentName;
    }

    /**
     * @param string $accidentName
     */
    public function setAccidentName($accidentName)
    {
        $this->accidentName = $accidentName;
    }

}

