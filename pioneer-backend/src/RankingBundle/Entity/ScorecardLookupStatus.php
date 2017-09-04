<?php

namespace RankingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ScorecardLookupStatus
 *
 * @ORM\Table(name="scorecard_lookup_status")
 * @ORM\Entity(repositoryClass="RankingBundle\Repository\ScorecardLookupStatusRepository")
 */
class ScorecardLookupStatus
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
     * @ORM\Column(name="shipids", type="string", length=255)
     */
    private $shipids;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="rejections", type="text", nullable=true)
     */
    private $rejections;

    /**
     * @var string
     *
     * @ORM\Column(name="temp_rejections", type="text", nullable=true)
     */
    private $temp_rejections;

    /**
     * @var boolean
     *
     * @ORM\Column(name="rejectionsStatus", type="boolean", nullable=false)
     */
    private $rejectionsStatus;

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
     * @return string
     */
    public function getShipids()
    {
        return $this->shipids;
    }

    /**
     * @param string $shipids
     */
    public function setShipids($shipids)
    {
        $this->shipids = $shipids;
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
     * @return string
     */
    public function getTempRejections()
    {
        return $this->temp_rejections;
    }

    /**
     * @param string $temp_rejections
     */
    public function setTempRejections($temp_rejections)
    {
        $this->temp_rejections = $temp_rejections;
    }

    /**
     * @return boolean
     */
    public function isRejectionsStatus()
    {
        return $this->rejectionsStatus;
    }

    /**
     * @param boolean $rejectionsStatus
     */
    public function setRejectionsStatus($rejectionsStatus)
    {
        $this->rejectionsStatus = $rejectionsStatus;
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

