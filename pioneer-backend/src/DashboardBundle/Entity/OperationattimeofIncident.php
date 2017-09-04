<?php

namespace DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OperationattimeofIncident
 *
 * @ORM\Table(name="operationattimeof_incident")
 * @ORM\Entity(repositoryClass="DashboardBundle\Repository\OperationattimeofIncidentRepository")
 */
class OperationattimeofIncident
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
     * @ORM\Column(name="timeofIncident", type="string", length=255)
     */
    private $timeofIncident;
    /**
     * @var string
     *
     * @ORM\Column(name="severityClassification", type="string", length=255,nullable=true)
     */
    private $severityClassification;



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
    public function getTimeofIncident()
    {
        return $this->timeofIncident;
    }

    /**
     * @param string $timeofIncident
     */
    public function setTimeofIncident($timeofIncident)
    {
        $this->timeofIncident = $timeofIncident;
    }

    /**
     * @return string
     */
    public function getSeverityClassification()
    {
        return $this->severityClassification;
    }

    /**
     * @param string $severityClassification
     */
    public function setSeverityClassification($severityClassification)
    {
        $this->severityClassification = $severityClassification;
    }


}

