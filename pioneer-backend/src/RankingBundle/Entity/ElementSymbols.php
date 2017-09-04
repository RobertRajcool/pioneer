<?php

namespace RankingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ElementSymbols
 *
 * @ORM\Table(name="element_symbols")
 * @ORM\Entity(repositoryClass="RankingBundle\Repository\ElementSymbolsRepository")
 */
class ElementSymbols
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
     * @ORM\Column(name="symbolName", type="string", length=255)
     */
    private $symbolName;

    /**
     * @var string
     *
     * @ORM\Column(name="symbolIndication", type="string", length=255)
     */
    private $symbolIndication;


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
    public function getSymbolName()
    {
        return $this->symbolName;
    }

    /**
     * @param string $symbolName
     */
    public function setSymbolName($symbolName)
    {
        $this->symbolName = $symbolName;
    }

    /**
     * @return string
     */
    public function getSymbolIndication()
    {
        return $this->symbolIndication;
    }

    /**
     * @param string $symbolIndication
     */
    public function setSymbolIndication($symbolIndication)
    {
        $this->symbolIndication = $symbolIndication;
    }


}

