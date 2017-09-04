<?php

namespace DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PlaceofAccident
 *
 * @ORM\Table(name="placeof_accident")
 * @ORM\Entity(repositoryClass="DashboardBundle\Repository\PlaceofAccidentRepository")
 */
class PlaceofAccident
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
     * @ORM\Column(name="placeName", type="string", length=255)
     */
    private $placeName;


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
    public function getPlaceName()
    {
        return $this->placeName;
    }

    /**
     * @param string $placeName
     */
    public function setPlaceName($placeName)
    {
        $this->placeName = $placeName;
    }
}

