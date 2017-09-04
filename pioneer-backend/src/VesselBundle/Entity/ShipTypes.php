<?php

namespace VesselBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ShipTypes
 *
 * @ORM\Table(name="ship_types")
 * @ORM\Entity(repositoryClass="VesselBundle\Repository\ShipTypesRepository")
 */
class ShipTypes
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
     * @ORM\Column(name="shipType", type="text", length=255)
     */
    private $shipType;


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
     * Set shipType
     *
     * @param string $shipType
     *
     * @return ShipTypes
     */
    public function setShipType($shipType)
    {
        $this->shipType = $shipType;

        return $this;
    }

    /**
     * Get shipType
     *
     * @return string
     */
    public function getShipType()
    {
        return $this->shipType;
    }
}

