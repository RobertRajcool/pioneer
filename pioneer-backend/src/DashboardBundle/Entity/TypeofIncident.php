<?php

namespace DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TypeofIncident
 *
 * @ORM\Table(name="typeof_incident")
 * @ORM\Entity(repositoryClass="DashboardBundle\Repository\TypeofIncidentRepository")
 */
class TypeofIncident
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
     * @ORM\Column(name="incidentName", type="string", length=255)
     */
    private $incidentName;
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
     * Set incidentName
     *
     * @param string $incidentName
     *
     * @return TypeofIncident
     */
    public function setIncidentName($incidentName)
    {
        $this->incidentName = $incidentName;

        return $this;
    }

    /**
     * Get incidentName
     *
     * @return string
     */
    public function getIncidentName()
    {
        return $this->incidentName;
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

