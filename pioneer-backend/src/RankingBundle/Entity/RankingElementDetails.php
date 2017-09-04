<?php

namespace RankingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RankingElementDetails
 *
 * @ORM\Table(name="ranking_element_details")
 * @ORM\Entity(repositoryClass="RankingBundle\Repository\RankingElementDetailsRepository")
 */
class RankingElementDetails
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
     * @ORM\ManyToOne(targetEntity="RankingBundle\Entity\RankingKpiDetails")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="kpiDetailsId", referencedColumnName="id")
     * })
     */
    private $kpiDetailsId;

    /**
     * @var string
     *
     * @ORM\Column(name="elementName", type="string", length=255)
     */
    private $elementName;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="cellName", type="string", length=255)
     */
    private $cellName;

    /**
     * @var string
     *
     * @ORM\Column(name="cellDetails", type="string", length=255, nullable=true)
     */
    private $cellDetails;


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
     * @ORM\Column(name="weightage", type="integer", length=255)
     */
    private $weightage;

    /**
     * @var string
     *
     * @ORM\Column(name="rules", type="string", length=255, nullable=true)
     */
    private $rules;

    /**
     * @var string
     *
     * @ORM\Column(name="vesselWiseTotal", type="string", length=35)
     */
    private $vesselWiseTotal;

    /**
     * @var string
     *
     * @ORM\Column(name="indicationValue", type="string", length=50)
     */
    private $indicationValue;

    /**
     * @var string
     * @ORM\ManyToOne(targetEntity="RankingBundle\Entity\ElementSymbols")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="symbolId", referencedColumnName="id")
     * })
     */
    private $symbolId;

    /**
     * @var string
     *
     * @ORM\Column(name="comparisonStatus", type="string", length=35)
     */
    private $comparisonStatus;

    /**
     * @var string
     *
     * @ORM\Column(name="baseValue", type="integer", length=11)
     */
    private $baseValue;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateTime", type="datetime")
     */
    private $dateTime;


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
    public function getKpiDetailsId()
    {
        return $this->kpiDetailsId;
    }

    /**
     * @param string $kpiDetailsId
     */
    public function setKpiDetailsId($kpiDetailsId)
    {
        $this->kpiDetailsId = $kpiDetailsId;
    }

    /**
     * @return string
     */
    public function getElementName()
    {
        return $this->elementName;
    }

    /**
     * @param string $elementName
     */
    public function setElementName($elementName)
    {
        $this->elementName = $elementName;
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
     * @return string
     */
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * @param string $rules
     */
    public function setRules($rules)
    {
        $this->rules = $rules;
    }

    /**
     * @return string
     */
    public function getVesselWiseTotal()
    {
        return $this->vesselWiseTotal;
    }

    /**
     * @param string $vesselWiseTotal
     */
    public function setVesselWiseTotal($vesselWiseTotal)
    {
        $this->vesselWiseTotal = $vesselWiseTotal;
    }

    /**
     * @return string
     */
    public function getIndicationValue()
    {
        return $this->indicationValue;
    }

    /**
     * @param string $indicationValue
     */
    public function setIndicationValue($indicationValue)
    {
        $this->indicationValue = $indicationValue;
    }

    /**
     * @return string
     */
    public function getSymbolId()
    {
        return $this->symbolId;
    }

    /**
     * @param string $symbolId
     */
    public function setSymbolId($symbolId)
    {
        $this->symbolId = $symbolId;
    }

    /**
     * @return string
     */
    public function getComparisonStatus()
    {
        return $this->comparisonStatus;
    }

    /**
     * @param string $comparisonStatus
     */
    public function setComparisonStatus($comparisonStatus)
    {
        $this->comparisonStatus = $comparisonStatus;
    }

    /**
     * @return string
     */
    public function getBaseValue()
    {
        return $this->baseValue;
    }

    /**
     * @param string $baseValue
     */
    public function setBaseValue($baseValue)
    {
        $this->baseValue = $baseValue;
    }

    /**
     * @return \DateTime
     */
    public function getDateTime()
    {
        return $this->dateTime;
    }

    /**
     * @param \DateTime $dateTime
     */
    public function setDateTime()
    {
        $this->dateTime = new \DateTime();
    }

}

