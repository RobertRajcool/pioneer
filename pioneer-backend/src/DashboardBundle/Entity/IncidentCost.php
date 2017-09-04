<?php

namespace DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IncidentCost
 *
 * @ORM\Table(name="incident_cost")
 * @ORM\Entity(repositoryClass="DashboardBundle\Repository\IncidentCostRepository")
 */
class IncidentCost
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
     *
     * @ORM\Column(name="incidentReportFinalCost", type="string", length=255,nullable=true)
     */
    private $incidentReportFinalCost;
    /**
     * @var string
     *
     * @ORM\Column(name="offHireDays", type="string", length=255,nullable=true)
     */
    private $offHireDays;
    /**
     * @var string
     *
     * @ORM\Column(name="managersCostUSD", type="string", length=255,nullable=true)
     */
    private $managersCostUSD;
    /**
     * @var string
     *
     * @ORM\Column(name="ownersCostUSD", type="string", length=255,nullable=true)
     */
    private $ownersCostUSD;
    /**
     * @var string
     *
     * @ORM\Column(name="incidentFinalCostUSD", type="string", length=255,nullable=true)
     */
    private $incidentFinalCostUSD;
    /**
     * @var string
     *
     * @ORM\Column(name="timebetweenincidentandincidentmade", type="string", nullable=true)
     */
    private $timebetweenincidentandincidentmade;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateReportsenttoowners", type="datetime", nullable=true)
     */
    private $dateReportsenttoowners;
    /**
     * @var string
     *
     * @ORM\Column(name="timebetweenincidentreportmadeandreportsendtoowners", type="string", length=255,nullable=true)
     */
    private $timebetweenincidentreportmadeandreportsendtoowners;
    /**
     * @var string
     *
     * @ORM\Column(name="incidentClosedbyOwners", type="string", length=255,nullable=true)
     */
    private $incidentClosedbyOwners;

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
    public function getIncidentReportFinalCost()
    {
        return $this->incidentReportFinalCost;
    }

    /**
     * @param string $incidentReportFinalCost
     */
    public function setIncidentReportFinalCost($incidentReportFinalCost)
    {
        $this->incidentReportFinalCost = $incidentReportFinalCost;
    }

    /**
     * @return string
     */
    public function getOffHireDays()
    {
        return $this->offHireDays;
    }

    /**
     * @param string $offHireDays
     */
    public function setOffHireDays($offHireDays)
    {
        $this->offHireDays = $offHireDays;
    }

    /**
     * @return string
     */
    public function getManagersCostUSD()
    {
        return $this->managersCostUSD;
    }

    /**
     * @param string $managersCostUSD
     */
    public function setManagersCostUSD($managersCostUSD)
    {
        $this->managersCostUSD = $managersCostUSD;
    }

    /**
     * @return string
     */
    public function getOwnersCostUSD()
    {
        return $this->ownersCostUSD;
    }

    /**
     * @param string $ownersCostUSD
     */
    public function setOwnersCostUSD($ownersCostUSD)
    {
        $this->ownersCostUSD = $ownersCostUSD;
    }

    /**
     * @return string
     */
    public function getIncidentFinalCostUSD()
    {
        return $this->incidentFinalCostUSD;
    }

    /**
     * @param string $incidentFinalCostUSD
     */
    public function setIncidentFinalCostUSD($incidentFinalCostUSD)
    {
        $this->incidentFinalCostUSD = $incidentFinalCostUSD;
    }

    /**
     * @return string
     */
    public function getTimebetweenincidentandincidentmade()
    {
        return $this->timebetweenincidentandincidentmade;
    }

    /**
     * @param string $timebetweenincidentandincidentmade
     */
    public function setTimebetweenincidentandincidentmade($timebetweenincidentandincidentmade)
    {
        $this->timebetweenincidentandincidentmade = $timebetweenincidentandincidentmade;
    }

    /**
     * @return \DateTime
     */
    public function getDateReportsenttoowners()
    {
        return $this->dateReportsenttoowners;
    }

    /**
     * @param \DateTime $dateReportsenttoowners
     */
    public function setDateReportsenttoowners($dateReportsenttoowners)
    {
        $this->dateReportsenttoowners = $dateReportsenttoowners;
    }

    /**
     * @return string
     */
    public function getTimebetweenincidentreportmadeandreportsendtoowners()
    {
        return $this->timebetweenincidentreportmadeandreportsendtoowners;
    }

    /**
     * @param string $timebetweenincidentreportmadeandreportsendtoowners
     */
    public function setTimebetweenincidentreportmadeandreportsendtoowners($timebetweenincidentreportmadeandreportsendtoowners)
    {
        $this->timebetweenincidentreportmadeandreportsendtoowners = $timebetweenincidentreportmadeandreportsendtoowners;
    }

    /**
     * @return string
     */
    public function getIncidentClosedbyOwners()
    {
        return $this->incidentClosedbyOwners;
    }

    /**
     * @param string $incidentClosedbyOwners
     */
    public function setIncidentClosedbyOwners($incidentClosedbyOwners)
    {
        $this->incidentClosedbyOwners = $incidentClosedbyOwners;
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



}

