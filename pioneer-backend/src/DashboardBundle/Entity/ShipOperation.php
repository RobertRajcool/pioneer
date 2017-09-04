<?php

namespace DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ShipOperation
 *
 * @ORM\Table(name="ship_operation")
 * @ORM\Entity(repositoryClass="DashboardBundle\Repository\ShipOperationRepository")
 */
class ShipOperation
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
     * @ORM\Column(name="operationname", type="string", length=255)
     */
    private $operationname;


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
    public function getOperationname()
    {
        return $this->operationname;
    }

    /**
     * @param string $operationname
     */
    public function setOperationname($operationname)
    {
        $this->operationname = $operationname;
    }
}

