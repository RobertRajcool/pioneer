<?php

namespace DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FactortoIncident
 *
 * @ORM\Table(name="factorto_incident")
 * @ORM\Entity(repositoryClass="DashboardBundle\Repository\FactortoIncidentRepository")
 */
class FactortoIncident
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
     * @ORM\Column(name="factorName", type="string", length=255)
     */
    private $factorName;
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
    public function getFactorName()
    {
        return $this->factorName;
    }

    /**
     * @param string $factorName
     */
    public function setFactorName($factorName)
    {
        $this->factorName = $factorName;
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

