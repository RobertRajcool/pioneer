<?php

namespace RankingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RankingKpiDetails
 *
 * @ORM\Table(name="ranking_kpi_details")
 * @ORM\Entity(repositoryClass="RankingBundle\Repository\RankingKpiDetailsRepository")
 */
class RankingKpiDetails
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
     *   @ORM\JoinColumn(name="shipDetailsId", referencedColumnName="id")
     * })
     */
    private $shipDetailsId;
    /**
     * @var string
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="userId", referencedColumnName="id")
     * })
     */
    private $userId;
    /**
     * @var string
     *
     * @ORM\Column(name="kpiName", type="string", length=255)
     */
    private $kpiName;
    /**
     * @var integer
     *
     * @ORM\Column(name="kpiStatusValue", type="integer")
     */
    private $kpiStatusValue;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="activeDate", type="date")
     */
    private $activeDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="endDate", type="date")
     */
    private $endDate;

    /**
     * @var string
     *
     * @ORM\Column(name="cellName", type="string", length=255, nullable=true)
     */
    private $cellName;

    /**
     * @var string
     *
     * @ORM\Column(name="cellDetails", type="string", length=255, nullable=true)
     */
    private $cellDetails;

    /**
     * @var string
     *
     * @ORM\Column(name="weightage", type="integer", length=255)
     */
    private $weightage;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdDateTime", type="datetime")
     */
    private $createdDateTime;


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
    public function getShipDetailsId()
    {
        return $this->shipDetailsId;
    }

    /**
     * @param string $shipDetailsId
     */
    public function setShipDetailsId($shipDetailsId)
    {
        $this->shipDetailsId = $shipDetailsId;
    }

    /**
     * @return string
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param string $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function getKpiName()
    {
        return $this->kpiName;
    }

    /**
     * @param string $kpiName
     */
    public function setKpiName($kpiName)
    {
        $this->kpiName = $kpiName;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return \DateTime
     */
    public function getActiveDate()
    {
        return $this->activeDate;
    }

    /**
     * @param \DateTime $activeDate
     */
    public function setActiveDate($activeDate)
    {
        $this->activeDate = $activeDate;
    }

    /**
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param \DateTime $endDate
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    }

    /**
     * @return string
     */
    public function getCellName()
    {
        return $this->cellName;
    }

    /**
     * @param string $cellName
     */
    public function setCellName($cellName)
    {
        $this->cellName = $cellName;
    }

    /**
     * @return string
     */
    public function getCellDetails()
    {
        return $this->cellDetails;
    }

    /**
     * @param string $cellDetails
     */
    public function setCellDetails($cellDetails)
    {
        $this->cellDetails = $cellDetails;
    }

    /**
     * @return string
     */
    public function getWeightage()
    {
        return $this->weightage;
    }

    /**
     * @param string $weightage
     */
    public function setWeightage($weightage)
    {
        $this->weightage = $weightage;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedDateTime()
    {
        return $this->createdDateTime;
    }

    /**
     * @param \DateTime $createdDateTime
     */
    public function setCreatedDateTime()
    {
        $this->createdDateTime = new \DateTime();
    }

    /**
     * @return int
     */
    public function getKpiStatusValue()
    {
        return $this->kpiStatusValue;
    }

    /**
     * @param int $kpiStatusValue
     */
    public function setKpiStatusValue($kpiStatusValue)
    {
        $this->kpiStatusValue = $kpiStatusValue;
    }



}

