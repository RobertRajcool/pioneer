<?php

namespace DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TypeofCause
 *
 * @ORM\Table(name="typeof_cause")
 * @ORM\Entity(repositoryClass="DashboardBundle\Repository\TypeofCauseRepository")
 */
class TypeofCause
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
     * @ORM\Column(name="causeName", type="string", length=255)
     */
    private $causeName;
    /**
     * @var string
     *
     * @ORM\Column(name="severityClassification", type="string", length=255)
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
     * Set causeName
     *
     * @param string $causeName
     *
     * @return TypeofCause
     */
    public function setCauseName($causeName)
    {
        $this->causeName = $causeName;

        return $this;
    }

    /**
     * Get causeName
     *
     * @return string
     */
    public function getCauseName()
    {
        return $this->causeName;
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

