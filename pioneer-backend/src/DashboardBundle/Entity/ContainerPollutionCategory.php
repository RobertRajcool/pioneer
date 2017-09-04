<?php

namespace DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContainerPollutionCategory
 *
 * @ORM\Table(name="container_pollution_category")
 * @ORM\Entity(repositoryClass="DashboardBundle\Repository\ContainerPollutionCategoryRepository")
 */
class ContainerPollutionCategory
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
     * @ORM\Column(name="con_pol_name", type="string", length=255)
     */
    private $con_pol_name;


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
    public function getConPolName()
    {
        return $this->con_pol_name;
    }

    /**
     * @param string $con_pol_name
     */
    public function setConPolName($con_pol_name)
    {
        $this->con_pol_name = $con_pol_name;
    }
}

