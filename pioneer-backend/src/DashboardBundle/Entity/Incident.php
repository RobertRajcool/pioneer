<?php

namespace DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Incident
 *
 * @ORM\Table(name="incident")
 * @ORM\Entity(repositoryClass="DashboardBundle\Repository\IncidentRepository")
 */
class Incident
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
     * @var integer
     *
     * @ORM\Column(name="incidentStatus", type="integer",  nullable=false)
     */
    private $incidentStatus;
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
     * @ORM\Column(name="incidentUId", type="string",  nullable=true)
     */
    private $incidentUId;


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
     * @return int
     */
    public function getIncidentStatus()
    {
        return $this->incidentStatus;
    }

    /**
     * @param int $incidentStatus
     */
    public function setIncidentStatus($incidentStatus)
    {
        $this->incidentStatus = $incidentStatus;
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
    public function getIncidentUId()
    {
        return $this->incidentUId;
    }

    /**
     * @param string $incidentUId
     */
    public function setIncidentUId($incidentUId)
    {
        $this->incidentUId = $incidentUId;
    }





}

