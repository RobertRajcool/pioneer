<?php

namespace RankingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RankingLookupStatus
 *
 * @ORM\Table(name="ranking_lookup_status")
 * @ORM\Entity(repositoryClass="RankingBundle\Repository\RankingLookupStatusRepository")
 */
class RankingLookupStatus
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
     * @var int
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="rejections", type="string", nullable=true)
     */
    private $rejections;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dataofmonth", type="date")
     */
    private $dataofmonth;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datetime", type="datetime")
     */
    private $datetime;
    /**
     * @var string
     *
     * @ORM\Column(name="userid", type="string", length=255)
     */
    private $userid;


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
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getRejections()
    {
        return $this->rejections;
    }

    /**
     * @param string $rejections
     */
    public function setRejections($rejections)
    {
        $this->rejections = $rejections;
    }

    /**
     * @return \DateTime
     */
    public function getDataofmonth()
    {
        return $this->dataofmonth;
    }

    /**
     * @param \DateTime $dataofmonth
     */
    public function setDataofmonth($dataofmonth)
    {
        $this->dataofmonth = $dataofmonth;
    }

    /**
     * @return \DateTime
     */
    public function getDatetime()
    {
        return $this->datetime;
    }

    /**
     * @param \DateTime $datetime
     */
    public function setDatetime($datetime)
    {
        $this->datetime = $datetime;
    }

    /**
     * @return string
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * @param string $userid
     */
    public function setUserid($userid)
    {
        $this->userid = $userid;
    }

}

