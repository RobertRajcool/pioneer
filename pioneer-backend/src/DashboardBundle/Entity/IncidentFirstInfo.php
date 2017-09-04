<?php

namespace DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IncidentFirstInfo
 *
 * @ORM\Table(name="incident_first_info")
 * @ORM\Entity(repositoryClass="DashboardBundle\Repository\IncidentFirstInfoRepository")
 */
class IncidentFirstInfo
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
     * @ORM\ManyToOne(targetEntity="DashboardBundle\Entity\Incident")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="incidentId", referencedColumnName="id")
     * })
     */
    private $incidentId;
    /**
     * @var string
     * @ORM\ManyToOne(targetEntity="DashboardBundle\Entity\TypeofIncident")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="typeofIncdientId", referencedColumnName="id")
     * })
     */
    private $typeofIncdientId;
    /**
     * @var string
     * @ORM\ManyToOne(targetEntity="VesselBundle\Entity\Shipdetails")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="shipId", referencedColumnName="id")
     * })
     */
    private $shipId;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateofIncident", type="datetime", nullable=true)
     */
    private $dateofIncident;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateofIncidentreportMade", type="datetime", nullable=true)
     */
    private $dateofIncidentreportMade;

    /**
     * @var string
     *
     * @ORM\Column(name="statusofReport", type="string", nullable=true)
     */
    private $statusofReport;
    /**
     * @var boolean
     *
     * @ORM\Column(name="incidentatSea", type="boolean", nullable=true)
     */
    private $incidentatSea;
    /**
     * @var boolean
     *
     * @ORM\Column(name="incidentDaylight", type="boolean", nullable=true)
     */
    private $incidentDaylight;
    /**
     * @var string
     *
     * @ORM\Column(name="location", type="string", nullable=true)
     */
    private $location;
    /**
     * @var string
     * @ORM\ManyToOne(targetEntity="DashboardBundle\Entity\HazardType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="hazardType", referencedColumnName="id")
     * })
     */
    private $hazardType;


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
    public function getIncidentId()
    {
        return $this->incidentId;
    }

    /**
     * @param string $incidentId
     */
    public function setIncidentId($incidentId)
    {
        $this->incidentId = $incidentId;
    }

    /**
     * @return string
     */
    public function getShipId()
    {
        return $this->shipId;
    }

    /**
     * @param string $shipId
     */
    public function setShipId($shipId)
    {
        $this->shipId = $shipId;
    }

    /**
     * @return \DateTime
     */
    public function getDateofIncident()
    {
        return $this->dateofIncident;
    }

    /**
     * @param \DateTime $dateofIncident
     */
    public function setDateofIncident($dateofIncident)
    {
        $this->dateofIncident = $dateofIncident;
    }

    /**
     * @return \DateTime
     */
    public function getDateofIncidentreportMade()
    {
        return $this->dateofIncidentreportMade;
    }

    /**
     * @param \DateTime $dateofIncidentreportMade
     */
    public function setDateofIncidentreportMade($dateofIncidentreportMade)
    {
        $this->dateofIncidentreportMade = $dateofIncidentreportMade;
    }

    /**
     * @return string
     */
    public function getStatusofReport()
    {
        return $this->statusofReport;
    }

    /**
     * @param string $statusofReport
     */
    public function setStatusofReport($statusofReport)
    {
        $this->statusofReport = $statusofReport;
    }

    /**
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param string $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * @return string
     */
    public function getTypeofIncdientId()
    {
        return $this->typeofIncdientId;
    }

    /**
     * @param string $typeofIncdientId
     */
    public function setTypeofIncdientId($typeofIncdientId)
    {
        $this->typeofIncdientId = $typeofIncdientId;
    }

    /**
     * @return boolean
     */
    public function isIncidentatSea()
    {
        return $this->incidentatSea;
    }

    /**
     * @param boolean $incidentatSea
     */
    public function setIncidentatSea($incidentatSea)
    {
        $this->incidentatSea = $incidentatSea;
    }

    /**
     * @return boolean
     */
    public function isIncidentDaylight()
    {
        return $this->incidentDaylight;
    }

    /**
     * @param boolean $incidentDaylight
     */
    public function setIncidentDaylight($incidentDaylight)
    {
        $this->incidentDaylight = $incidentDaylight;
    }

    /**
     * @return string
     */
    public function getHazardType()
    {
        return $this->hazardType;
    }

    /**
     * @param string $hazardType
     */
    public function setHazardType($hazardType)
    {
        $this->hazardType = $hazardType;
    }



}

