<?php

namespace DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IncidentDetails
 *
 * @ORM\Table(name="incident_details")
 * @ORM\Entity(repositoryClass="DashboardBundle\Repository\IncidentDetailsRepository")
 */
class IncidentDetails
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
     * @ORM\ManyToOne(targetEntity="DashboardBundle\Entity\TypeofCause")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="typeofCause", referencedColumnName="id")
     * })
     */
    private $typeofCause;
    /**
     * @var string
     *
     * @ORM\Column(name="totalDemage", type="string", length=255)
     */
    private $totalDemage;
    /**
     * @var string
     *
     * @ORM\Column(name="rcaRequired", type="string", length=255)
     */
    private $rcaRequired;
    /**
     * @var string
     * @ORM\ManyToOne(targetEntity="DashboardBundle\Entity\OperationattimeofIncident")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="operationattimeofIncident", referencedColumnName="id")
     * })
     */
    private $operationattimeofIncident;
    /**
     * @var string
     * @ORM\ManyToOne(targetEntity="DashboardBundle\Entity\FactortoIncident")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="factortoIncident", referencedColumnName="id")
     * })
     */
    private $factortoIncident;
    /**
     * @var string
     *
     * @ORM\Column(name="incidentDescription", type="string", length=255)
     */
    private $incidentDescription;
    /**
     * @var string
     *
     * @ORM\Column(name="immediateAction", type="string", length=255)
     */
    private $immediateAction;
    /**
     * @var string
     *
     * @ORM\Column(name="followupAction", type="string", length=255)
     */
    private $followupAction;


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
    public function getTypeofCause()
    {
        return $this->typeofCause;
    }

    /**
     * @param string $typeofCause
     */
    public function setTypeofCause($typeofCause)
    {
        $this->typeofCause = $typeofCause;
    }

    /**
     * @return string
     */
    public function getTotalDemage()
    {
        return $this->totalDemage;
    }

    /**
     * @param string $totalDemage
     */
    public function setTotalDemage($totalDemage)
    {
        $this->totalDemage = $totalDemage;
    }

    /**
     * @return string
     */
    public function getRcaRequired()
    {
        return $this->rcaRequired;
    }

    /**
     * @param string $rcaRequired
     */
    public function setRcaRequired($rcaRequired)
    {
        $this->rcaRequired = $rcaRequired;
    }

    /**
     * @return string
     */
    public function getFactortoIncident()
    {
        return $this->factortoIncident;
    }

    /**
     * @param string $factortoIncident
     */
    public function setFactortoIncident($factortoIncident)
    {
        $this->factortoIncident = $factortoIncident;
    }

    /**
     * @return string
     */
    public function getIncidentDescription()
    {
        return $this->incidentDescription;
    }

    /**
     * @param string $incidentDescription
     */
    public function setIncidentDescription($incidentDescription)
    {
        $this->incidentDescription = $incidentDescription;
    }

    /**
     * @return string
     */
    public function getImmediateAction()
    {
        return $this->immediateAction;
    }

    /**
     * @param string $immediateAction
     */
    public function setImmediateAction($immediateAction)
    {
        $this->immediateAction = $immediateAction;
    }

    /**
     * @return string
     */
    public function getFollowupAction()
    {
        return $this->followupAction;
    }

    /**
     * @param string $followupAction
     */
    public function setFollowupAction($followupAction)
    {
        $this->followupAction = $followupAction;
    }

    /**
     * @return string
     */
    public function getOperationattimeofIncident()
    {
        return $this->operationattimeofIncident;
    }

    /**
     * @param string $operationattimeofIncident
     */
    public function setOperationattimeofIncident($operationattimeofIncident)
    {
        $this->operationattimeofIncident = $operationattimeofIncident;
    }


}

