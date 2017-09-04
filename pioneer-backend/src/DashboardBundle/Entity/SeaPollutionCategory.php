<?php

namespace DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SeaPollutionCategory
 *
 * @ORM\Table(name="sea_pollution_category")
 * @ORM\Entity(repositoryClass="DashboardBundle\Repository\SeaPollutionCategoryRepository")
 */
class SeaPollutionCategory
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
     * @ORM\Column(name="sea_pol_name", type="string", length=255)
     */
    private $sea_pol_name;


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
    public function getSeaPolName()
    {
        return $this->sea_pol_name;
    }

    /**
     * @param string $sea_pol_name
     */
    public function setSeaPolName($sea_pol_name)
    {
        $this->sea_pol_name = $sea_pol_name;
    }
}

