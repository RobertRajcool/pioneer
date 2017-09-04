<?php

namespace RankingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RankingRulesDetails
 *
 * @ORM\Table(name="ranking_rules_details")
 * @ORM\Entity(repositoryClass="RankingBundle\Repository\RankingRulesDetailsRepository")
 */
class RankingRulesDetails
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
     *   @ORM\JoinColumn(name="kpiDetailsId", referencedColumnName="id")
     * })
     */
    private $kpiDetailsId;

    /**
     * @var string
     * @ORM\ManyToOne(targetEntity="RankingBundle\Entity\RankingElementDetails")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="elementDetailsId", referencedColumnName="id")
     * })
     */
    private $elementDetailsId;

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
     * @var \DateTime
     *
     * @ORM\Column(name="createdDateTime", type="datetime", nullable=true)
     */
    private $createdDateTime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updatedDateTime", type="datetime", nullable=true)
     */
    private $updatedDateTime;


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
     * Set kpiDetailsId
     *
     * @param string $kpiDetailsId
     *
     * @return RankingRulesDetails
     */
    public function setKpiDetailsId($kpiDetailsId)
    {
        $this->kpiDetailsId = $kpiDetailsId;

        return $this;
    }

    /**
     * Get kpiDetailsId
     *
     * @return string
     */
    public function getKpiDetailsId()
    {
        return $this->kpiDetailsId;
    }

    /**
     * Set elementDetailsId
     *
     * @param string $elementDetailsId
     *
     * @return RankingRulesDetails
     */
    public function setElementDetailsId($elementDetailsId)
    {
        $this->elementDetailsId = $elementDetailsId;

        return $this;
    }

    /**
     * Get elementDetailsId
     *
     * @return string
     */
    public function getElementDetailsId()
    {
        return $this->elementDetailsId;
    }

    /**
     * Set rules
     *
     * @param string $rules
     *
     * @return RankingRulesDetails
     */
    public function setRules($rules)
    {
        $this->rules = $rules;

        return $this;
    }

    /**
     * Get rules
     *
     * @return string
     */
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * Set rulesOrder
     *
     * @param string $rulesOrder
     *
     * @return RankingRulesDetails
     */
    public function setRulesOrder($rulesOrder)
    {
        $this->rulesOrder = $rulesOrder;

        return $this;
    }

    /**
     * Get rulesOrder
     *
     * @return string
     */
    public function getRulesOrder()
    {
        return $this->rulesOrder;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedDateTime()
    {
        return $this->createdDateTime;
    }

    /**
     * @param \DateTime $createdDateTime
     */
    public function setCreatedDateTime()
    {
        $this->createdDateTime = new \DateTime();
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedDateTime()
    {
        return $this->updatedDateTime;
    }

    /**
     * @param \DateTime $updatedDateTime
     */
    public function setUpdatedDateTime()
    {
        $this->updatedDateTime = new \DateTime();
    }



}

