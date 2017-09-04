<?php

namespace DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IncidentStatisticsData
 *
 * @ORM\Table(name="incident_statistics_data")
 * @ORM\Entity(repositoryClass="DashboardBundle\Repository\IncidentStatisticsDataRepository")
 */
class IncidentStatisticsData
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
     * @var int
     *
     * @ORM\Column(name="typeof_stat_data", type="integer", nullable=true)
     */
    private $typeof_stat_data;
    /**
     * @var string
     *
     * @ORM\Column(name="dutyStatus", type="string", nullable=true)
     */
    private $dutyStatus;
    /**
     * @var string
     *
     * @ORM\Column(name="rankStatus", type="string", nullable=true)
     */
    private $rankStatus;
    /**
     * @var string
     *
     * @ORM\Column(name="typeofInjury", type="string", nullable=true)
     */
    private $typeofInjury;
    /**
     * @var string
     *
     * @ORM\Column(name="typeofAccident", type="string", nullable=true)
     */
    private $typeofAccident;
    /**
     * @var string
     *
     * @ORM\Column(name="placeofAccident", type="string", nullable=true)
     */
    private $placeofAccident;
    /**
     * @var string
     *
     * @ORM\Column(name="bodyareaAffected", type="string", nullable=true)
     */
    private $bodyareaAffected;
    /**
     * @var string
     *
     * @ORM\Column(name="shipoperation", type="string", nullable=true)
     */
    private $shipoperation;
    /**
     * @var string
     *
     * @ORM\Column(name="primaryequimentdemage", type="string", nullable=true)
     */
    private $primaryequimentdemage;
    /**
     * @var string
     *
     * @ORM\Column(name="demagepart", type="string", nullable=true)
     */
    private $demagepart;
    /**
     * @var string
     *
     * @ORM\Column(name="demagethirdparty", type="string", nullable=true)
     */
    private $demagethirdparty;
    /**
     * @var string
     *
     * @ORM\Column(name="detailsofincident", type="string", nullable=true)
     */
    private $detailsofincident;
    /**
     * @var string
     *
     * @ORM\Column(name="demagedrug_alcohol", type="string", nullable=true)
     */
    private $demagedrug_alcohol;
    /**
     * @var string
     *
     * @ORM\Column(name="spills_sea_liter", type="string", nullable=true)
     */
    private $spills_sea_liter;
    /**
     * @var string
     *
     * @ORM\Column(name="spills_sea_pol_cate", type="string", nullable=true)
     */
    private $spills_sea_pol_cate;
    /**
     * @var string
     *
     * @ORM\Column(name="spills_sea_pol_cate_other", type="string", nullable=true)
     */
    private $spills_sea_pol_cate_other;
    /**
     * @var string
     *
     * @ORM\Column(name="spills_contain_liter", type="string", nullable=true)
     */
    private $spills_contain_liter;
    /**
     * @var string
     *
     * @ORM\Column(name="spills_contain_pol_cate", type="string", nullable=true)
     */
    private $spills_contain_pol_cate;
    /**
     * @var string
     *
     * @ORM\Column(name="spills_contain_liter_other", type="string", nullable=true)
     */
    private $spills_contain_liter_other;



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
     * @return int
     */
    public function getTypeofStatData()
    {
        return $this->typeof_stat_data;
    }

    /**
     * @param int $typeof_stat_data
     */
    public function setTypeofStatData($typeof_stat_data)
    {
        $this->typeof_stat_data = $typeof_stat_data;
    }

    /**
     * @return string
     */
    public function getDutyStatus()
    {
        return $this->dutyStatus;
    }

    /**
     * @param string $dutyStatus
     */
    public function setDutyStatus($dutyStatus)
    {
        $this->dutyStatus = $dutyStatus;
    }

    /**
     * @return string
     */
    public function getRankStatus()
    {
        return $this->rankStatus;
    }

    /**
     * @param string $rankStatus
     */
    public function setRankStatus($rankStatus)
    {
        $this->rankStatus = $rankStatus;
    }

    /**
     * @return string
     */
    public function getTypeofInjury()
    {
        return $this->typeofInjury;
    }

    /**
     * @param string $typeofInjury
     */
    public function setTypeofInjury($typeofInjury)
    {
        $this->typeofInjury = $typeofInjury;
    }

    /**
     * @return string
     */
    public function getTypeofAccident()
    {
        return $this->typeofAccident;
    }

    /**
     * @param string $typeofAccident
     */
    public function setTypeofAccident($typeofAccident)
    {
        $this->typeofAccident = $typeofAccident;
    }

    /**
     * @return string
     */
    public function getPlaceofAccident()
    {
        return $this->placeofAccident;
    }

    /**
     * @param string $placeofAccident
     */
    public function setPlaceofAccident($placeofAccident)
    {
        $this->placeofAccident = $placeofAccident;
    }

    /**
     * @return string
     */
    public function getBodyareaAffected()
    {
        return $this->bodyareaAffected;
    }

    /**
     * @param string $bodyareaAffected
     */
    public function setBodyareaAffected($bodyareaAffected)
    {
        $this->bodyareaAffected = $bodyareaAffected;
    }

    /**
     * @return string
     */
    public function getShipoperation()
    {
        return $this->shipoperation;
    }

    /**
     * @param string $shipoperation
     */
    public function setShipoperation($shipoperation)
    {
        $this->shipoperation = $shipoperation;
    }

    /**
     * @return string
     */
    public function getPrimaryequimentdemage()
    {
        return $this->primaryequimentdemage;
    }

    /**
     * @param string $primaryequimentdemage
     */
    public function setPrimaryequimentdemage($primaryequimentdemage)
    {
        $this->primaryequimentdemage = $primaryequimentdemage;
    }

    /**
     * @return string
     */
    public function getDemagepart()
    {
        return $this->demagepart;
    }

    /**
     * @param string $demagepart
     */
    public function setDemagepart($demagepart)
    {
        $this->demagepart = $demagepart;
    }

    /**
     * @return string
     */
    public function getDemagethirdparty()
    {
        return $this->demagethirdparty;
    }

    /**
     * @param string $demagethirdparty
     */
    public function setDemagethirdparty($demagethirdparty)
    {
        $this->demagethirdparty = $demagethirdparty;
    }

    /**
     * @return string
     */
    public function getDetailsofincident()
    {
        return $this->detailsofincident;
    }

    /**
     * @param string $detailsofincident
     */
    public function setDetailsofincident($detailsofincident)
    {
        $this->detailsofincident = $detailsofincident;
    }

    /**
     * @return string
     */
    public function getDemagedrugAlcohol()
    {
        return $this->demagedrug_alcohol;
    }

    /**
     * @param string $demagedrug_alcohol
     */
    public function setDemagedrugAlcohol($demagedrug_alcohol)
    {
        $this->demagedrug_alcohol = $demagedrug_alcohol;
    }

    /**
     * @return string
     */
    public function getSpillsSeaLiter()
    {
        return $this->spills_sea_liter;
    }

    /**
     * @param string $spills_sea_liter
     */
    public function setSpillsSeaLiter($spills_sea_liter)
    {
        $this->spills_sea_liter = $spills_sea_liter;
    }

    /**
     * @return string
     */
    public function getSpillsSeaPolCate()
    {
        return $this->spills_sea_pol_cate;
    }

    /**
     * @param string $spills_sea_pol_cate
     */
    public function setSpillsSeaPolCate($spills_sea_pol_cate)
    {
        $this->spills_sea_pol_cate = $spills_sea_pol_cate;
    }

    /**
     * @return string
     */
    public function getSpillsSeaPolCateOther()
    {
        return $this->spills_sea_pol_cate_other;
    }

    /**
     * @param string $spills_sea_pol_cate_other
     */
    public function setSpillsSeaPolCateOther($spills_sea_pol_cate_other)
    {
        $this->spills_sea_pol_cate_other = $spills_sea_pol_cate_other;
    }

    /**
     * @return string
     */
    public function getSpillsContainLiter()
    {
        return $this->spills_contain_liter;
    }

    /**
     * @param string $spills_contain_liter
     */
    public function setSpillsContainLiter($spills_contain_liter)
    {
        $this->spills_contain_liter = $spills_contain_liter;
    }

    /**
     * @return string
     */
    public function getSpillsContainPolCate()
    {
        return $this->spills_contain_pol_cate;
    }

    /**
     * @param string $spills_contain_pol_cate
     */
    public function setSpillsContainPolCate($spills_contain_pol_cate)
    {
        $this->spills_contain_pol_cate = $spills_contain_pol_cate;
    }

    /**
     * @return string
     */
    public function getSpillsContainLiterOther()
    {
        return $this->spills_contain_liter_other;
    }

    /**
     * @param string $spills_contain_liter_other
     */
    public function setSpillsContainLiterOther($spills_contain_liter_other)
    {
        $this->spills_contain_liter_other = $spills_contain_liter_other;
    }

}

