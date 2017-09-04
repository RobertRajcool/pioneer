<?php

namespace DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HazardType
 *
 * @ORM\Table(name="hazard_type")
 * @ORM\Entity(repositoryClass="DashboardBundle\Repository\HazardTypeRepository")
 */
class HazardType
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
     * @ORM\Column(name="hazardName", type="string", length=255)
     */
    private $hazardName;


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
    public function getHazardName()
    {
        return $this->hazardName;
    }

    /**
     * @param string $hazardName
     */
    public function setHazardName($hazardName)
    {
        $this->hazardName = $hazardName;
    }

}

