<?php

namespace RankingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RankingKpiRulesDetails
 *
 * @ORM\Table(name="ranking_kpi_rules_details")
 * @ORM\Entity(repositoryClass="RankingBundle\Repository\RankingKpiRulesDetailsRepository")
 */
class RankingKpiRulesDetails
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
     * @ORM\ManyToOne(targetEntity="RankingBundle\Entity\RankingKpiDetails")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="kpiId", referencedColumnName="id")
     * })
     */
    private $kpiId;
    /**
     * @var string
     *
     * @ORM\Column(name="rules", type="text")
     */
    private $rules;

    /**
     * @var string
     *
     * @ORM\Column(name="rulesOrder", type="text")
     */
    private $rulesOrder;


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
    public function getKpiId()
    {
        return $this->kpiId;
    }

    /**
     * @param string $kpiId
     */
    public function setKpiId($kpiId)
    {
        $this->kpiId = $kpiId;
    }

    /**
     * @return string
     */
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * @param string $rules
     */
    public function setRules($rules)
    {
        $this->rules = $rules;
    }

    /**
     * @return string
     */
    public function getRulesOrder()
    {
        return $this->rulesOrder;
    }

    /**
     * @param string $rulesOrder
     */
    public function setRulesOrder($rulesOrder)
    {
        $this->rulesOrder = $rulesOrder;
    }

}

