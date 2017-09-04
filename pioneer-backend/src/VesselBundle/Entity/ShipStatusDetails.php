<?php

namespace VesselBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ShipStatusDetails
 *
 * @ORM\Table(name="ship_status_details")
 * @ORM\Entity(repositoryClass="VesselBundle\Repository\ShipStatusDetailsRepository")
 */
class ShipStatusDetails
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
     * @ORM\ManyToOne(targetEntity="VesselBundle\Entity\Shipdetails")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ShipDetailsId", referencedColumnName="id")
     * })
     */
    private $shipDetailsId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="activeDate", type="datetime", nullable=true)
     */
    private $activeDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="endDate", type="datetime", nullable=true)
     */
    private $endDate;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;


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
     * Set shipDetailsId
     *
     * @param string $shipDetailsId
     *
     * @return ShipStatusDetails
     */
    public function setShipDetailsId($shipDetailsId)
    {
        $this->shipDetailsId = $shipDetailsId;

        return $this;
    }

    /**
     * Get shipDetailsId
     *
     * @return string
     */
    public function getShipDetailsId()
    {
        return $this->shipDetailsId;
    }

    /**
     * Set activeDate
     *
     * @param \DateTime $activeDate
     *
     * @return ShipStatusDetails
     */
    public function setActiveDate($activeDate)
    {
        $this->activeDate = $activeDate;

        return $this;
    }

    /**
     * Get activeDate
     *
     * @return \DateTime
     */
    public function getActiveDate()
    {
        return $this->activeDate;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     *
     * @return ShipStatusDetails
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return ShipStatusDetails
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }
}

