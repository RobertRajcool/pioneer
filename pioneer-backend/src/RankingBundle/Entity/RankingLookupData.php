<?php

namespace RankingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RankingLookupData
 *
 * @ORM\Table(name="ranking_lookup_data")
 * @ORM\Entity(repositoryClass="RankingBundle\Repository\RankingLookupDataRepository")
 */
class RankingLookupData
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
     * @ORM\Column(name="elementdata", type="string", length=255)
     */

    private $elementdata;

    /**
     * @var string
     *
     * @ORM\Column(name="elementcolor", type="string", length=255)
     */
    private $elementcolor;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="monthdetail", type="date")
     */
    private $monthdetail;

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
     * @ORM\ManyToOne(targetEntity="RankingBundle\Entity\RankingKpiDetails")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="kpiDetailsId", referencedColumnName="id")
     * })
     */
    private $kpiDetailsId;

    /**
     * @var string
     * @ORM\ManyToOne(targetEntity="RankingBundle\Entity\RankingElementDetails")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="elementDetailsId", referencedColumnName="id")
     * })
     */
    private $elementDetailsId;

    /**
     * @return string
     */
    public function getElementdata()
    {
        return $this->elementdata;
    }

    /**
     * @param string $elementdata
     */
    public function setElementdata($elementdata)
    {
        $this->elementdata = $elementdata;
    }

    /**
     * @return string
     */
    public function getElementcolor()
    {
        return $this->elementcolor;
    }

    /**
     * @param string $elementcolor
     */
    public function setElementcolor($elementcolor)
    {
        $this->elementcolor = $elementcolor;
    }

    /**
     * @return \DateTime
     */
    public function getMonthdetail()
    {
        return $this->monthdetail;
    }

    /**
     * @param \DateTime $monthdetail
     */
    public function setMonthdetail($monthdetail)
    {
        $this->monthdetail = $monthdetail;
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
    public function getElementDetailsId()
    {
        return $this->elementDetailsId;
    }

    /**
     * @param string $elementDetailsId
     */
    public function setElementDetailsId($elementDetailsId)
    {
        $this->elementDetailsId = $elementDetailsId;
    }



    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}

